FROM php:8.1-fpm-alpine

ARG USER_ID
ARG GROUP_ID
ARG APP_NAME

RUN apk add --no-cache bash

RUN addgroup --gid ${GROUP_ID} ${APP_NAME} \
    && adduser --disabled-password --uid ${USER_ID} --ingroup ${APP_NAME} ${APP_NAME}

RUN apk add --no-cache bash $PHPIZE_DEPS \
    && pecl install xdebug-3.1.3 \
    && docker-php-ext-enable xdebug

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

ENTRYPOINT ["/bin/sh", "/entrypoint.sh"]
USER ${APP_NAME}

