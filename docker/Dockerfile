# Dockerfile для Store_Project (php-fpm)
# Основан на php:8.3-fpm-alpine

FROM php:8.3-fpm-alpine

# Метаданные
LABEL maintainer="Store Project Team"
LABEL description="PHP-FPM контейнер для Store_Project"

# Установка зависимостей
RUN apk add --no-cache \
    curl \
    git \
    zip \
    unzip \
    mysql-client \
    bash

# Установка PHP расширений
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mysqli \
    opcache

# Копирование php.ini конфига (опционально)
# COPY docker/php.ini /usr/local/etc/php/conf.d/store-project.ini

# Рабочая папка
WORKDIR /var/www/html

# Директория для сессий
RUN mkdir -p /var/lib/php/sessions && \
    chown -R www-data:www-data /var/lib/php/sessions

# Права доступа
RUN chown -R www-data:www-data /var/www/html

# Health check
HEALTHCHECK --interval=30s --timeout=10s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:9000/ping 2>/dev/null || exit 1

EXPOSE 9000

CMD ["php-fpm"]

