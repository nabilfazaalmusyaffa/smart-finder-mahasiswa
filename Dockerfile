FROM php:8.3-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git unzip zip curl \
    libzip-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev libxml2-dev default-mysql-client nodejs npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

RUN if [ -f package.json ]; then npm install && npm run build; fi

RUN chmod -R 775 storage bootstrap/cache || true

EXPOSE 8080

CMD sh -c "php artisan config:clear || true && php artisan storage:link || true && php artisan serve --host=0.0.0.0 --port=${PORT:-8080}"