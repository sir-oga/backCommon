FROM registry.gitlab.igenv.com:5050/docker/nginx-php-fpm:latest

WORKDIR /var/www/html
COPY . /var/www/html

#composer
ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer install --prefer-dist

STOPSIGNAL SIGTERM
