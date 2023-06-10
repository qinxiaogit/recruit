FROM php:7.4.22-fpm-bullseye AS base

WORKDIR /workspace

# timezone environment
ENV TZ=UTC \
  # locale
  LANG=en_US.UTF-8 \
  LANGUAGE=en_US:en \
  LC_ALL=en_US.UTF-8 \
  # composer environment
  COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

RUN apt-get update \
  && apt-get -y install --no-install-recommends \
    locales \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* \
  && locale-gen en_US.UTF-8 \
  && localedef -f UTF-8 -i en_US en_US.UTF-8 \
  && docker-php-ext-install \
    intl \
    pdo_mysql \
    zip \
    bcmath \
  && composer config -g process-timeout 3600 \
  && composer config -g repos.packagist composer https://mirrors.aliyun.com/composer/

FROM base AS development

#COPY ./dockerfiles/php.development.ini /usr/local/etc/php/php.ini

FROM development AS development-xdebug

#COPY ./dockerfiles/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

FROM base AS deploy

#COPY ./dockerfiles/php.deploy.ini /usr/local/etc/php/php.ini
COPY ./ /workspace

# RUN composer install -q -n --no-ansi --no-dev --no-scripts --no-progress --prefer-dist \
#   && chmod -R 777 storage bootstrap/cache \
#   && php artisan optimize:clear \
#   && php artisan optimize
