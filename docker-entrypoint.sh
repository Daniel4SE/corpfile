#!/bin/bash
set -e

PORT=${PORT:-8080}

# Fix Apache MPM conflict at runtime
if apache2ctl -M 2>/dev/null | grep -q mpm_event; then
  a2dismod mpm_event 2>/dev/null || true
  a2enmod mpm_prefork 2>/dev/null || true
fi

# Update Apache port to match $PORT
sed -i "s/Listen [0-9]*/Listen $PORT/" /etc/apache2/ports.conf
sed -i "s/:8080>/:$PORT>/" /etc/apache2/sites-available/000-default.conf
sed -i "s/:80>/:$PORT>/" /etc/apache2/sites-available/000-default.conf

# Ensure uploads directory is writable
mkdir -p /var/www/html/uploads
chown -R www-data:www-data /var/www/html/uploads

# Run DB migrations (idempotent)
DB_HOST="${DB_HOST:-localhost}"
DB_USER="${DB_USER:-root}"
DB_PASS="${DB_PASS:-}"
DB_NAME="${DB_NAME:-corporate_secretary}"

if [ -n "$DB_HOST" ] && [ "$DB_HOST" != "localhost" ]; then
  echo "Running DB migrations..."
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
  echo "DB migrations done."
fi

exec "$@"
