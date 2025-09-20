FROM php:8.2-fpm

# Устанавливаем зависимости и Supervisor
RUN apt-get update && apt-get install -y \
    supervisor \
    libcurl4-openssl-dev \
    libzip-dev \
    unzip \
    git \
    nginx \
 && docker-php-ext-install pdo_mysql zip curl \
 && apt-get clean && rm -rf /var/lib/apt/lists/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


WORKDIR /app
COPY . /app

RUN composer install --optimize-autoloader --no-dev

RUN echo "server { \
    listen 80; \
    server_name localhost; \
    root /app/public; \
    index index.php index.html; \
    location / { \
        try_files \$uri \$uri/ /index.php?\$query_string; \
    } \
    location ~ \.php\$ { \
        include fastcgi_params; \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_index index.php; \
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name; \
    } \
}" > /etc/nginx/sites-available/default

RUN chown -R www-data:www-data /app \
    && chmod -R 775 /app/storage /app/bootstrap/cache

CMD composer install  && php artisan migrate --force && supervisord -c /etc/supervisor/supervisord.conf && php-fpm && nginx -g "daemon off;"
