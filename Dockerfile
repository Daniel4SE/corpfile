FROM php:8.2-apache

# Install PHP extensions
RUN apt-get update && apt-get install -y \
    ca-certificates libpng-dev libjpeg-dev libfreetype6-dev libzip-dev unzip curl default-mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mysqli zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Fix Apache MPM: disable event, enable prefork (required for mod_php)
RUN a2dismod mpm_event 2>/dev/null || true \
    && a2enmod mpm_prefork \
    && a2enmod rewrite

# Apache config: allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Set permissions
RUN mkdir -p /var/www/html/uploads \
    && chown -R www-data:www-data /var/www/html/uploads \
    && chmod -R 755 /var/www/html/uploads

# Copy entrypoint script
COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

EXPOSE 8080

# Apache listen on 8080
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf \
    && sed -i 's/:80>/:8080>/' /etc/apache2/sites-available/000-default.conf

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
