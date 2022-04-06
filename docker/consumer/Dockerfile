FROM php:8.0.14-apache

ENV TZ=UTC

# Install system dependencies
RUN apt update &&\
    apt install -y --no-install-recommends git zip unzip tzdata procps autoconf g++ make

# Chnage system timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Download and install Redis
RUN mkdir -p /usr/src/php/ext/redis &&\
    curl -sL https://github.com/phpredis/phpredis/archive/5.3.4.tar.gz | tar xvz -C /usr/src/php/ext/redis --strip 1 &&\
    echo 'redis' >> /usr/src/php-available-exts

# Install PHP extensions
RUN docker-php-ext-install redis bcmath pdo_mysql pcntl

# Override PHP configs
COPY ./docker/web/php/php.ini /usr/local/etc/php/conf.d/

# Get latest Composer
COPY --from=composer:2.1.14 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project diretories and files
COPY --chown=www-data:www-data . .

# Enable custom config for serving website
COPY ./docker/web/apache/vhost.conf /etc/apache2/sites-available/000-default.conf
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
	&& a2enmod rewrite \
	&& service apache2 restart

EXPOSE 80
