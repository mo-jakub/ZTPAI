FROM php:8.4.4-fpm-alpine3.21

## Install necessary dependencies
RUN apk add --no-cache $PHPIZE_DEPS linux-headers bash curl

ENV RUN_DEPS="\
    zlib \
    libzip \
    libpng \
    libjpeg-turbo \
    postgresql-libs"

ENV BUILD_DEPS="\
    zlib-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    postgresql-dev"

ENV PHP_EXTENSIONS="\
    opcache \
    zip \
    gd \
    bcmath \
    pgsql \
    pdo_pgsql"

RUN apk add --no-cache --virtual .build-deps $BUILD_DEPS rabbitmq-c-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install -j "$(nproc)" $PHP_EXTENSIONS \
    && pecl install amqp \
    && docker-php-ext-enable amqp \
    && apk del .build-deps

RUN apk add --no-cache --virtual .run-deps $RUN_DEPS rabbitmq-c

RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash && \
    apk add --no-cache symfony-cli

COPY --from=composer /usr/bin/composer /usr/bin/composer