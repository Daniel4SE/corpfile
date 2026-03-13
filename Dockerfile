FROM php:8.2-cli

# Install PHP extensions and mysql client
RUN apt-get update && apt-get install -y \
    ca-certificates libpng-dev libjpeg-dev libfreetype6-dev libzip-dev unzip curl default-mysql-client \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mysqli zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Increase PHP limits for file upload via JSON (base64 encoded)
RUN echo "post_max_size = 50M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "upload_max_filesize = 50M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "memory_limit = 256M" >> /usr/local/etc/php/conf.d/uploads.ini

COPY . .

RUN mkdir -p /var/www/html/uploads \
    && chmod -R 755 /var/www/html/uploads

COPY docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

EXPOSE 8080

ENTRYPOINT ["/docker-entrypoint.sh"]
CMD ["php", "-S", "0.0.0.0:8080", "index.php"]
