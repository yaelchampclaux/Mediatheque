FROM php:8.3-cli

RUN useradd -ms /bin/bash you

# Installation des dépendances système
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

# Configuration PHP optimisée pour Symfony
RUN echo "memory_limit = 512M" > /usr/local/etc/php/conf.d/symfony.ini \
    && echo "opcache.enable = 1" >> /usr/local/etc/php/conf.d/symfony.ini \
    && echo "opcache.memory_consumption = 256" >> /usr/local/etc/php/conf.d/symfony.ini \
    && echo "opcache.max_accelerated_files = 20000" >> /usr/local/etc/php/conf.d/symfony.ini \
    && echo "opcache.validate_timestamps = 1" >> /usr/local/etc/php/conf.d/symfony.ini \
    && echo "realpath_cache_size = 4096K" >> /usr/local/etc/php/conf.d/symfony.ini \
    && echo "realpath_cache_ttl = 600" >> /usr/local/etc/php/conf.d/symfony.ini

# Installer composer en root
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN mkdir -p /home/you/site && chown -R you:you /home/you

# Changer vers l'utilisateur you
USER you
WORKDIR /home/you

# Serveur php symfony
#CMD [ "php", "-S", "0.0.0.0:8800", "-t", "site/public" ]
CMD [ "sh", "-c", "[ -d site/public ] && php -S 0.0.0.0:8800 -t site/public || tail -f /dev/null" ]

# to install a new symfony project with 7.4.3 LTS version
# docker exec -it php-mediatheque /bin/bash
# composer create-project symfony/skeleton:"7.4.*" site