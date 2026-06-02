FROM php:8.3-apache

WORKDIR /var/www/html

# Install dependency Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    curl \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Apache: pakai hanya mpm_prefork dan rewrite
RUN set -eux; \
    rm -f /etc/apache2/mods-enabled/mpm_event.*; \
    rm -f /etc/apache2/mods-enabled/mpm_worker.*; \
    rm -f /etc/apache2/mods-enabled/mpm_prefork.*; \
    a2enmod mpm_prefork rewrite

# Arahkan Apache ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project
COPY . .

# Install dependency PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Build asset frontend jika ada package.json
RUN if [ -f package.json ]; then npm install && npm run build; fi

# Permission Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Jangan sampai storage:link bikin crash kalau sudah ada
RUN php artisan storage:link || true

EXPOSE 80

CMD ["apache2-foreground"]