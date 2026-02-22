# Deployment Guide

## Prerequisites

| Software | Minimum Version | Recommended |
|----------|----------------|-------------|
| PHP | 8.0+ | 8.2+ |
| MySQL | 8.0+ | 8.0+ |
| Apache (prod) | 2.4+ | 2.4+ with mod_rewrite |
| PHP Extensions | pdo, pdo_mysql, mbstring, json, session | + openssl, curl, fileinfo |

## Option A: Development Setup (PHP Built-in Server)

### 1. Install PHP and MySQL

**macOS (Homebrew)**:
```bash
brew install php mysql
brew services start mysql
```

**Ubuntu/Debian**:
```bash
sudo apt update
sudo apt install php8.2 php8.2-mysql php8.2-mbstring mysql-server
sudo systemctl start mysql
```

**Windows**: Install XAMPP or WampServer.

### 2. Create Database

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS corporate_secretary CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 3. Import Schema and Seed Data

```bash
mysql -u root corporate_secretary < database/schema.sql
mysql -u root corporate_secretary < database/seed.sql
```

### 4. Configure Database Connection

Edit `application/config/database.php`:

```php
return [
    'hostname' => 'localhost',
    'username' => 'root',
    'password' => '',          // Set your MySQL password if any
    'database' => 'corporate_secretary',
    'port'     => 3306,
    'charset'  => 'utf8mb4',
];
```

### 5. Configure Base URL

Edit `application/config/config.php`:

```php
$config['base_url'] = 'http://localhost:8080/';
```

### 6. Start the Server

```bash
php -S localhost:8080 router.php
```

### 7. Access the Application

Open: http://localhost:8080/welcome/login

**Login Credentials**:
- Company ID: `YY244`
- Username: `accountingtang`
- Password: `Pass@123`

---

## Option B: Production Setup (Apache)

### 1. Install LAMP Stack

```bash
# Ubuntu/Debian
sudo apt update
sudo apt install apache2 php8.2 php8.2-mysql php8.2-mbstring libapache2-mod-php8.2 mysql-server
sudo a2enmod rewrite
sudo systemctl restart apache2
```

### 2. Deploy Application

```bash
# Copy to web root
sudo cp -r teamwork-demo /var/www/teamwork
sudo chown -R www-data:www-data /var/www/teamwork
sudo chmod -R 755 /var/www/teamwork
sudo chmod -R 775 /var/www/teamwork/uploads
```

### 3. Apache Virtual Host Configuration

Create `/etc/apache2/sites-available/teamwork.conf`:

```apache
<VirtualHost *:80>
    ServerName teamwork.example.com
    DocumentRoot /var/www/teamwork

    <Directory /var/www/teamwork>
        AllowOverride All
        Require all granted
    </Directory>

    # Deny access to application directory
    <Directory /var/www/teamwork/application>
        Require all denied
    </Directory>

    # Deny access to database directory
    <Directory /var/www/teamwork/database>
        Require all denied
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/teamwork-error.log
    CustomLog ${APACHE_LOG_DIR}/teamwork-access.log combined
</VirtualHost>
```

Enable the site:
```bash
sudo a2ensite teamwork
sudo systemctl reload apache2
```

### 4. Create MySQL Database and User

```sql
CREATE DATABASE corporate_secretary CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'teamwork'@'localhost' IDENTIFIED BY 'your_secure_password';
GRANT ALL PRIVILEGES ON corporate_secretary.* TO 'teamwork'@'localhost';
FLUSH PRIVILEGES;
```

```bash
mysql -u teamwork -p corporate_secretary < database/schema.sql
mysql -u teamwork -p corporate_secretary < database/seed.sql
```

### 5. Update Configuration

`application/config/database.php`:
```php
return [
    'hostname' => 'localhost',
    'username' => 'teamwork',
    'password' => 'your_secure_password',
    'database' => 'corporate_secretary',
    'port'     => 3306,
    'charset'  => 'utf8mb4',
];
```

`application/config/config.php`:
```php
$config['base_url'] = 'https://teamwork.example.com/';
```

### 6. SSL (Recommended)

```bash
sudo apt install certbot python3-certbot-apache
sudo certbot --apache -d teamwork.example.com
```

---

## Option C: Docker Setup

### Dockerfile

```dockerfile
FROM php:8.2-apache

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring

# Enable mod_rewrite
RUN a2enmod rewrite

# Copy application
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html/uploads

# Apache config
RUN echo '<Directory /var/www/html>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/teamwork.conf \
    && a2enconf teamwork

EXPOSE 80
```

### docker-compose.yml

```yaml
version: '3.8'
services:
  app:
    build: .
    ports:
      - "8080:80"
    depends_on:
      - db
    environment:
      - DB_HOST=db
      - DB_USER=teamwork
      - DB_PASS=teamwork_pass
      - DB_NAME=corporate_secretary
    volumes:
      - ./uploads:/var/www/html/uploads

  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: root_pass
      MYSQL_DATABASE: corporate_secretary
      MYSQL_USER: teamwork
      MYSQL_PASSWORD: teamwork_pass
    volumes:
      - ./database/schema.sql:/docker-entrypoint-initdb.d/01-schema.sql
      - ./database/seed.sql:/docker-entrypoint-initdb.d/02-seed.sql
      - db_data:/var/lib/mysql

volumes:
  db_data:
```

```bash
docker-compose up -d
# Access at http://localhost:8080
```

---

## Directory Permissions

| Directory | Permission | Purpose |
|-----------|-----------|---------|
| `uploads/` | 775 (www-data) | User file uploads |
| `uploads/companies/` | 775 (www-data) | Company documents |
| `uploads/members/` | 775 (www-data) | Member documents |
| `application/` | 755 | Application code (read-only) |
| `database/` | 700 | Schema files (restrict access) |

## Security Checklist

- [ ] MySQL user has limited privileges (only the `corporate_secretary` database)
- [ ] `application/` directory is not web-accessible (Apache `Require all denied`)
- [ ] `database/` directory is not web-accessible
- [ ] `uploads/.htaccess` prevents PHP execution in uploads directory
- [ ] SSL/TLS enabled in production
- [ ] `display_errors = Off` in PHP production config
- [ ] Session cookies set to `HttpOnly` and `Secure`
- [ ] Change default seed data passwords before production use
- [ ] Regular database backups configured

## Troubleshooting

### Common Issues

**1. Blank page / 500 error**
```bash
# Check PHP error log
tail -f /var/log/apache2/teamwork-error.log
# Or enable display_errors temporarily
php -d display_errors=1 -S localhost:8080 router.php
```

**2. Database connection failed**
```bash
# Test MySQL connection
mysql -u teamwork -p -e "SELECT 1" corporate_secretary
# Check database.php credentials match
```

**3. 404 on all pages**
- Apache: Ensure `mod_rewrite` is enabled and `AllowOverride All` is set
- PHP built-in server: Must use `router.php` as the router script

**4. CSS/JS not loading**
- Check that `public/vendors/` directory contains all 17 vendor libraries
- For PHP built-in server, `router.php` handles serving static files from `public/`
- For Apache, `.htaccess` handles URL rewriting

**5. Login fails**
```bash
# Verify password hash
mysql -u root corporate_secretary -e "SELECT username, password FROM users WHERE username='accountingtang';"
# The hash should be a bcrypt hash starting with $2y$
```

## Backup and Restore

### Database Backup
```bash
mysqldump -u root corporate_secretary > backup_$(date +%Y%m%d).sql
```

### Database Restore
```bash
mysql -u root corporate_secretary < backup_20260219.sql
```

### Full Application Backup
```bash
tar -czf teamwork_backup_$(date +%Y%m%d).tar.gz \
    --exclude=scraped_pages \
    --exclude=scraped_assets \
    teamwork-demo/
```

## Environment Variables (Optional)

For production, you can use environment variables instead of hardcoded config:

```php
// application/config/database.php
return [
    'hostname' => getenv('DB_HOST') ?: 'localhost',
    'username' => getenv('DB_USER') ?: 'root',
    'password' => getenv('DB_PASS') ?: '',
    'database' => getenv('DB_NAME') ?: 'corporate_secretary',
    'port'     => getenv('DB_PORT') ?: 3306,
    'charset'  => 'utf8mb4',
];
```
