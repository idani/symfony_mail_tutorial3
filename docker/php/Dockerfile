#FROM php:7.3-fpm-alpine
FROM php:7.3-alpine

# Install dev dependencies
RUN apk update \
    && apk upgrade --available \
    && apk add --virtual build-deps \
    autoconf \
    build-base \
    icu-dev \
    libevent-dev \
    openssl-dev \
    zlib-dev \
    libzip \
    libzip-dev \
    zlib \
    zlib-dev \
    bzip2 \
    git \
    mysql-client \
    nodejs \
    nodejs-npm \
    yarn \
    libpng \
    libpng-dev \
    libjpeg \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype \
    freetype-dev \
    curl \
    wget \
    bash \
    chromium \
    tzdata \
    ssmtp \
    unzip \
    && cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && echo "Asia/Tokyo" > /etc/timezone

# Install and configure NodeJS Package Manager (npm)
ENV NODE_ENV development
RUN npm install -g npm
RUN npm config set cache ~/.cache/npm

# Install Composer
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_HOME /composer

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    && composer config -g repos.packagist composer https://packagist.jp \
    && composer global require hirak/prestissimo \
    && wget https://get.symfony.com/cli/installer -O - | bash \
    && mv /root/.symfony/bin/symfony /usr/local/bin/symfony

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install -j$(getconf _NPROCESSORS_ONLN) \
    intl \
    gd \
    mbstring \
    pdo_mysql \
    sockets \
    zip
RUN pecl channel-update pecl.php.net \
    && pecl install -o -f \
    redis \
    event \
    && rm -rf /tmp/pear \
    && echo "extension=redis.so" > /usr/local/etc/php/conf.d/redis.ini \
    && echo "extension=event.so" > /usr/local/etc/php/conf.d/event.ini

WORKDIR /var/www/html

EXPOSE 8000
