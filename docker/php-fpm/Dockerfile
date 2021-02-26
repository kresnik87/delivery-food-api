FROM php:7.4-fpm-alpine

COPY wait-for-it.sh /usr/bin/wait-for-it

RUN chmod +x /usr/bin/wait-for-it

RUN apk --update --no-cache add git

RUN docker-php-ext-install pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN composer self-update --1

WORKDIR /var/www

CMD composer install ; bin/console doctrine:migrations:migrate ;  php-fpm 

EXPOSE 9000
