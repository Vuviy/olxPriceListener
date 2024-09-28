# PHP 8.3
FROM php:8.3-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    cron \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl zip pdo pdo_mysql bcmath sockets opcache


RUN apt-get update && apt-get install -y supervisor

RUN apt-get update && apt-get install -y procps

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Clean cache apt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy crontab
COPY ./crontab /etc/cron.d/laravel-cron
RUN chmod 0644 /etc/cron.d/laravel-cron
RUN crontab /etc/cron.d/laravel-cron

# Supervisor config
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Work directory
WORKDIR /var/www/html

# Expose port
EXPOSE 9000

CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]