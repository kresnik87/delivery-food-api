FROM php:8.1.6-fpm-alpine
WORKDIR /application

RUN wget https://github.com/FriendsOfPHP/pickle/releases/download/v0.7.9/pickle.phar \
    && mv pickle.phar /usr/local/bin/pickle \
    && chmod +x /usr/local/bin/pickle


RUN apk --update upgrade \
    && apk add --no-cache bash npm  openssl-dev autoconf ca-certificates-bundle automake make gcc g++ bash icu-dev libzip-dev rabbitmq-c rabbitmq-c-dev curl-dev mysql supervisor

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions apcu intl  bcmath opcache pcov pdo_mysql

RUN docker-php-ext-configure pcntl --enable-pcntl \
  && docker-php-ext-install pcntl;

RUN pickle install apcu@5.1.21

RUN apk add git

ADD php/extensions/rabbitmq.sh /root/install-rabbitmq.sh
RUN sh /root/install-rabbitmq.sh

RUN docker-php-ext-enable \
        apcu \
        amqp  \
        opcache


RUN apk add --no-cache bash
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' |   bash
RUN apk add symfony-cli

COPY php/ /usr/local/etc/php/
COPY php/supervisor/supervisor.conf /etc/supervisor/conf.d/
COPY php/docker-php-entrypoint /usr/local/bin/

RUN mkdir -p /application/apps/delivery-api/var/cache/prod /application/apps/delivery-api/var/cache/dev /application/apps/delivery-api/var/cache/test /application/apps/api/var/log \
   && chown -R www-data:www-data /application/apps/delivery-api/var/ \
   && chmod -R ug+rwX /application/apps/delivery-api/var/

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD composer i  --no-interaction --optimize-autoloader ;
RUN mkdir -p /opt/home
RUN chmod 777 /opt/home
ENV HOME /opt/home

RUN chmod +x /usr/local/bin/docker-php-entrypoint

CMD ["/usr/bin/supervisord","-c","/etc/supervisor/conf.d/supervisor.conf"]
