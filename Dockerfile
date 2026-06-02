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
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    nodejs \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Aktifkan rewrite saja, JANGAN utak-atik MPM
RUN a2enmod rewrite

# Arahkan Apache ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf \
    /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy semua file project
COPY . .

# Install dependency PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Build asset frontend jika ada package.json
RUN if [ -f package.json ]; then npm install && npm run build; fi

# Permission Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD php artisan optimize:clear || true && \
    php artisan storage:link || true && \
    apache2-foreground