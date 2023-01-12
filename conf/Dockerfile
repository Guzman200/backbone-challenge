FROM php:8.0.5-fpm-alpine

LABEL maintainer="my.rg.developer@gmail.com"

# Replace repositories
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories

# fix timezone
ARG TIME_ZONE=America/Monterrey
ENV TZ ${TIME_ZONE}
RUN apk add --no-cache tzdata \
    && cp /usr/share/zoneinfo/${TIME_ZONE} /etc/localtime \
    && echo "${TIME_ZONE}" > /etc/timezone \
    && apk del tzdata

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql

# defined extension deps
ENV PHP_INSTALL_EXT_DEPS \
    # for zip
    libzip-dev \
    # for intl
    icu-dev \
    # for imap
    imap-dev openssl-dev \
    # for tidy
    tidyhtml-dev \
    # for gd
    freetype-dev libjpeg-turbo-dev libpng-dev

# Install extensions deps
RUN apk update \
	&& apk add --no-cache \
    libzip \
    icu \
    imap c-client \
    tidyhtml \
    freetype libpng libjpeg-turbo \
    && apk add --update --no-cache --virtual .build-ext-deps $PHP_INSTALL_EXT_DEPS \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure imap  \
    && docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install  pdo_mysql zip intl imap tidy pcntl opcache bcmath gd \
    && docker-php-ext-configure gd \
    && apk del .build-ext-deps



# Pecl install
#RUN apk add --no-cache \
#    libmemcached \
#	&& apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
#		libmemcached-dev \
#        zlib-dev \
#     && pecl install redis memcached \
#     && docker-php-ext-enable redis memcached \
#     && rm -rf /tmp/pear \
#     && apk del -f .build-deps

# Use the default production configuration
RUN cp "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Change current user to www
USER www-data

# Exxpose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]