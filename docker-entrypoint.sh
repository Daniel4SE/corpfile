#!/bin/bash
set -e

PORT=${PORT:-8080}
sed -i "s/Listen 8080/Listen $PORT/" /etc/apache2/ports.conf
sed -i "s/:8080>/:$PORT>/" /etc/apache2/sites-available/000-default.conf

# Run DB migrations (idempotent)
DB_HOST="${DB_HOST:-localhost}"
DB_USER="${DB_USER:-root}"
DB_PASS="${DB_PASS:-}"
DB_NAME="${DB_NAME:-corporate_secretary}"

mysql -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASS" "$DB_NAME" 2>/dev/null <<'SQL' || true
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

exec "$@"
