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
  echo "DB migrations done."

  # Run Teamwork.sg data import (one-time, checks a flag)
  IMPORT_DONE=$(mysql $MYSQL_OPTS -N -e "SELECT COUNT(*) FROM companies WHERE incorporation_date IS NOT NULL AND client_id = (SELECT id FROM clients LIMIT 1)" "$DB_NAME" 2>/dev/null || echo "0")
  if [ "$IMPORT_DONE" -lt "30" ] && [ -f /var/www/html/data_import/import_to_corpfile.php ]; then
    echo "Running Teamwork.sg data import..."
    php /var/www/html/data_import/import_to_corpfile.php 2>&1 || true
    echo "Teamwork.sg data import complete."
  else
    echo "Teamwork.sg data already imported, skipping."
  fi
fi

# Start PHP built-in server (same as local dev)
echo "Starting CorpFile on port $PORT..."
exec php -S "0.0.0.0:$PORT" -t /var/www/html /var/www/html/index.php
