FROM php:8.3-cli

RUN useradd -ms /bin/bash you

WORKDIR /home/you

RUN apt-get update && apt-get install -y \
        git \
        zip \
        unzip \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libonig-dev \
        libxml2-dev \
        libzip-dev \
        libcurl4-openssl-dev \
        libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        gd \
        iconv \
        mysqli \
        pdo_mysql \
        intl \
        zip \
        dom \
        xml \
        simplexml \
        xmlreader \
        xmlwriter \
        mbstring \
        curl \
        intl \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

USER you

# Installer composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Serveur php symfony
CMD [ "php", "-S", "0.0.0.0:8800", "-t", "site/public" ]

# to install a new symfony project 
# docker exec -it php-mediatheque /bin/bash
# ./composer.phar create-project symfony/skeleton site