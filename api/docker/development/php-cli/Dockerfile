ARG PHP_VERSION

FROM php:${PHP_VERSION}-cli-alpine

ARG XDEBUG_VERSION

RUN apk add --no-cache linux-headers git pcre-dev icu-dev ${PHPIZE_DEPS} \
    && git clone --branch ${XDEBUG_VERSION} --depth 1 https://github.com/xdebug/xdebug.git /usr/src/php/ext/xdebug \
    && docker-php-ext-configure xdebug --enable-xdebug-dev \
    && docker-php-ext-install xdebug intl \
    && apk del git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

COPY ./common/php/conf.d /usr/local/etc/php/conf.d

WORKDIR /application