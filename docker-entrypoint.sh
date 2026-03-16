#!/bin/bash
set -e

PORT=${PORT:-8080}

# Ensure uploads directory is writable
mkdir -p /var/www/html/uploads

# Run DB migrations (idempotent)
DB_HOST="${DB_HOST:-localhost}"
DB_USER="${DB_USER:-root}"
DB_PASS="${DB_PASS:-}"
DB_NAME="${DB_NAME:-corporate_secretary}"
DB_PORT="${DB_PORT:-3306}"

# Common mysql options (disable SSL for Railway's self-signed certs)
# Use --skip-ssl for MariaDB client, --ssl-mode=DISABLED for MySQL client
SSL_FLAG=""
if mysql --help 2>&1 | grep -q "skip-ssl"; then
  SSL_FLAG="--skip-ssl"
elif mysql --help 2>&1 | grep -q "ssl-mode"; then
  SSL_FLAG="--ssl-mode=DISABLED"
fi
MYSQL_OPTS="-h${DB_HOST} -P${DB_PORT} -u${DB_USER} -p${DB_PASS} ${SSL_FLAG}"

if [ -n "$DB_HOST" ] && [ "$DB_HOST" != "localhost" ]; then
  echo "Waiting for MySQL to be ready..."
  for i in $(seq 1 30); do
    if mysql $MYSQL_OPTS -e "SELECT 1" "$DB_NAME" >/dev/null 2>&1; then
      echo "MySQL is ready."
      break
    fi
    echo "Waiting for MySQL... ($i/30)"
    sleep 2
  done

  # Check if the database is empty (no 'clients' table = needs seeding)
  TABLE_COUNT=$(mysql $MYSQL_OPTS -N -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='$DB_NAME' AND table_name='clients'" "$DB_NAME" 2>/dev/null || echo "0")

  if [ "$TABLE_COUNT" = "0" ]; then
    echo "Database is empty — importing seed data..."
    if [ -f /var/www/html/db_seed.sql ]; then
      mysql $MYSQL_OPTS "$DB_NAME" < /var/www/html/db_seed.sql 2>&1
      echo "Database seed import complete."
    else
      echo "WARNING: db_seed.sql not found, skipping import."
    fi
  else
    echo "Database already has tables, skipping seed import."
  fi

  # Run additional migrations (idempotent)
  echo "Running DB migrations..."
  mysql $MYSQL_OPTS "$DB_NAME" 2>/dev/null <<'SQL' || true
CREATE TABLE IF NOT EXISTS `oauth_users` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `provider` VARCHAR(50) NOT NULL,
  `provider_uid` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) DEFAULT NULL,
  `name` VARCHAR(255) DEFAULT NULL,
  `avatar` VARCHAR(500) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE,
  UNIQUE KEY `uk_provider_uid` (`provider`, `provider_uid`)
) ENGINE=InnoDB;
SQL

  mysql $MYSQL_OPTS "$DB_NAME" 2>/dev/null <<'SQL' || true
ALTER TABLE `companies` ADD COLUMN IF NOT EXISTS `is_accounting_client` TINYINT DEFAULT 0;
ALTER TABLE `companies` ADD COLUMN IF NOT EXISTS `is_audit_client` TINYINT DEFAULT 0;
ALTER TABLE `companies` ADD COLUMN IF NOT EXISTS `is_listed_related` TINYINT DEFAULT 0;
SQL

  # Chat history tables
  mysql $MYSQL_OPTS "$DB_NAME" 2>/dev/null <<'SQL' || true
CREATE TABLE IF NOT EXISTS `chat_conversations` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `user_id` INT UNSIGNED NOT NULL,
  `client_id` INT UNSIGNED NOT NULL,
  `title` VARCHAR(255) DEFAULT 'New Chat',
  `agent` VARCHAR(50) DEFAULT NULL COMMENT 'null=general, or agent key like compliance, tax, etc',
  `source` ENUM('chat','drawer','agent') DEFAULT 'chat' COMMENT 'which UI originated this',
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_user_client` (`user_id`, `client_id`),
  INDEX `idx_updated` (`updated_at` DESC)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `chat_messages` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `conversation_id` INT UNSIGNED NOT NULL,
  `role` ENUM('user','assistant') NOT NULL,
  `content` TEXT NOT NULL,
  `model` VARCHAR(100) DEFAULT NULL,
  `tokens_in` INT DEFAULT NULL,
  `tokens_out` INT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`conversation_id`) REFERENCES `chat_conversations`(`id`) ON DELETE CASCADE,
  INDEX `idx_conversation` (`conversation_id`)
) ENGINE=InnoDB;
SQL

  # Change requests table (for CorpSec task tracking)
  mysql $MYSQL_OPTS "$DB_NAME" 2>/dev/null <<'SQL' || true
CREATE TABLE IF NOT EXISTS `change_requests` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `company_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `change_type` VARCHAR(100) NOT NULL COMMENT 'e.g. change_address, appoint_director, resign_director, change_name, etc.',
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `form_data` JSON COMMENT 'structured form fields submitted by user',
  `status` ENUM('draft','pending','in_progress','completed','rejected','cancelled') DEFAULT 'pending',
  `priority` ENUM('low','normal','high','urgent') DEFAULT 'normal',
  `assigned_to` INT UNSIGNED DEFAULT NULL,
  `resolved_at` DATETIME DEFAULT NULL,
  `notes` TEXT,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_company` (`company_id`),
  INDEX `idx_client_status` (`client_id`, `status`),
  INDEX `idx_type` (`change_type`)
) ENGINE=InnoDB;
SQL
  # eSign tables
  mysql $MYSQL_OPTS "$DB_NAME" 2>/dev/null <<'SQL' || true
CREATE TABLE IF NOT EXISTS `esign_documents` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `company_id` INT UNSIGNED DEFAULT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `document_type` VARCHAR(100) DEFAULT 'General',
  `file_path` VARCHAR(500) DEFAULT NULL,
  `file_name` VARCHAR(255) DEFAULT NULL,
  `status` ENUM('Draft','Sent','Partially Signed','Completed','Voided','Expired') DEFAULT 'Draft',
  `routing_order` ENUM('sequential','parallel') DEFAULT 'parallel',
  `expires_at` DATETIME DEFAULT NULL,
  `sent_at` DATETIME DEFAULT NULL,
  `completed_at` DATETIME DEFAULT NULL,
  `voided_at` DATETIME DEFAULT NULL,
  `void_reason` TEXT DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_client` (`client_id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_company` (`company_id`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `esign_signers` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `esign_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `role` ENUM('Signer','Approver','Viewer','CC') DEFAULT 'Signer',
  `routing_order` INT DEFAULT 1,
  `status` ENUM('Pending','Sent','Viewed','Completed','Declined','Expired') DEFAULT 'Pending',
  `signed_at` DATETIME DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `signature_data` TEXT DEFAULT NULL,
  `decline_reason` TEXT DEFAULT NULL,
  `reminder_sent_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`esign_id`) REFERENCES `esign_documents`(`id`) ON DELETE CASCADE,
  INDEX `idx_esign` (`esign_id`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS `esign_audit_log` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `esign_id` INT UNSIGNED NOT NULL,
  `event` VARCHAR(100) NOT NULL,
  `details` TEXT DEFAULT NULL,
  `user_name` VARCHAR(255) DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`esign_id`) REFERENCES `esign_documents`(`id`) ON DELETE CASCADE,
  INDEX `idx_esign` (`esign_id`)
) ENGINE=InnoDB;
SQL

  # Recreate eSign tables with correct schema (drop old incomplete tables)
  mysql $MYSQL_OPTS "$DB_NAME" 2>/dev/null <<'SQL' || true
DROP TABLE IF EXISTS `esign_audit_log`;
DROP TABLE IF EXISTS `esign_signers`;
DROP TABLE IF EXISTS `esign_documents`;
SQL
  mysql $MYSQL_OPTS "$DB_NAME" 2>/dev/null <<'SQL' || true
CREATE TABLE `esign_documents` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `client_id` INT UNSIGNED NOT NULL,
  `company_id` INT UNSIGNED DEFAULT NULL,
  `document_id` INT UNSIGNED DEFAULT NULL,
  `title` VARCHAR(255) NOT NULL,
  `subject` VARCHAR(500) DEFAULT NULL,
  `message` TEXT DEFAULT NULL,
  `description` TEXT,
  `file_path` VARCHAR(500) DEFAULT NULL,
  `file_name` VARCHAR(255) DEFAULT NULL,
  `document_type` VARCHAR(100) DEFAULT 'General',
  `status` ENUM('Draft','Sent','Partially Signed','Completed','Voided','Expired') DEFAULT 'Draft',
  `signing_order` ENUM('sequential','parallel') DEFAULT 'parallel',
  `routing_order` ENUM('sequential','parallel') DEFAULT 'parallel',
  `unique_key` VARCHAR(50) DEFAULT NULL,
  `expires_at` DATETIME DEFAULT NULL,
  `sent_at` DATETIME DEFAULT NULL,
  `completed_at` DATETIME DEFAULT NULL,
  `voided_at` DATETIME DEFAULT NULL,
  `void_reason` TEXT DEFAULT NULL,
  `created_by` INT UNSIGNED DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX `idx_client` (`client_id`),
  INDEX `idx_status` (`status`),
  INDEX `idx_company` (`company_id`),
  INDEX `idx_unique_key` (`unique_key`)
) ENGINE=InnoDB;

CREATE TABLE `esign_signers` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `esign_id` INT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `role` ENUM('Signer','Approver','Viewer','CC') DEFAULT 'Signer',
  `routing_order` INT DEFAULT 1,
  `status` ENUM('Pending','Sent','Viewed','Completed','Declined','Expired') DEFAULT 'Pending',
  `signed_at` DATETIME DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `signature_data` TEXT DEFAULT NULL,
  `decline_reason` TEXT DEFAULT NULL,
  `reminder_sent_at` DATETIME DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`esign_id`) REFERENCES `esign_documents`(`id`) ON DELETE CASCADE,
  INDEX `idx_esign` (`esign_id`),
  INDEX `idx_status` (`status`)
) ENGINE=InnoDB;

CREATE TABLE `esign_audit_log` (
  `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `esign_id` INT UNSIGNED NOT NULL,
  `event` VARCHAR(100) NOT NULL,
  `details` TEXT DEFAULT NULL,
  `user_name` VARCHAR(255) DEFAULT NULL,
  `ip_address` VARCHAR(45) DEFAULT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (`esign_id`) REFERENCES `esign_documents`(`id`) ON DELETE CASCADE,
  INDEX `idx_esign` (`esign_id`)
) ENGINE=InnoDB;
SQL

  mysql $MYSQL_OPTS "$DB_NAME" 2>/dev/null <<'SQL' || true
CREATE TABLE IF NOT EXISTS `work_passes` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `company_id` INT NOT NULL,
  `member_id` INT DEFAULT NULL,
  `holder_name` VARCHAR(255) NOT NULL,
  `pass_type` ENUM('EP','DP','S Pass','Work Permit','EntrePass','PEP','LOC','TEP','Other') NOT NULL,
  `fin_number` VARCHAR(50) DEFAULT NULL,
  `pass_number` VARCHAR(100) DEFAULT NULL,
  `nationality` VARCHAR(100) DEFAULT NULL,
  `sponsor_name` VARCHAR(255) DEFAULT NULL,
  `sector` VARCHAR(100) DEFAULT NULL,
  `quota_type` VARCHAR(50) DEFAULT NULL,
  `issue_date` DATE DEFAULT NULL,
  `expiry_date` DATE DEFAULT NULL,
  `status` VARCHAR(50) DEFAULT 'Active',
  `remarks` TEXT DEFAULT NULL,
  `client_id` INT DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;
SQL

  echo "DB migrations done."

  # Run Teamwork.sg data import (one-time, checks if enough companies have incorp dates)
  IMPORT_DONE=$(mysql $MYSQL_OPTS -N -e "SELECT COUNT(*) FROM companies WHERE incorporation_date IS NOT NULL AND client_id = (SELECT id FROM clients LIMIT 1)" "$DB_NAME" 2>/dev/null || echo "0")
  if [ "$IMPORT_DONE" -lt "50" ] && [ -f /var/www/html/data_import/import_to_corpfile.php ]; then
    echo "Running Teamwork.sg data import..."
    php /var/www/html/data_import/import_to_corpfile.php 2>&1 || true
    echo "Teamwork.sg data import complete."
  else
    echo "Teamwork.sg data already imported, skipping."
  fi

  # Migrate company_officials into dedicated tables (directors, shareholders, secretaries, auditors)
  if [ -f /var/www/html/data_import/migrate_officials.php ]; then
    echo "Running officials migration..."
    php /var/www/html/data_import/migrate_officials.php 2>&1 || true
  fi
fi

# Start PHP built-in server (same as local dev)
echo "Starting CorpFile on port $PORT..."
exec php -S "0.0.0.0:$PORT" -t /var/www/html /var/www/html/index.php
