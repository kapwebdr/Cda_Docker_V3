FROM php:8.4.13-fpm-trixie

RUN apt-get update && apt-get install -y git zip unzip \
    && apt-get install -y libmagickwand-dev libcurl4-openssl-dev pkg-config libssl-dev libmcrypt-dev libxml2-dev\
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php \
    && docker-php-ext-install opcache \
    && docker-php-ext-install soap \
    && docker-php-ext-install calendar \
    && docker-php-ext-install sockets \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && docker-php-ext-configure calendar \
    && pecl install apcu imagick && docker-php-ext-enable apcu opcache soap imagick sockets \
    && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false \ 
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*