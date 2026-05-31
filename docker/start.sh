#!/bin/bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan storage:link || true
php artisan migrate --force || true
php artisan config:cache
apache2-foreground
