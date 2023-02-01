FROM php:8.1-apache
RUN apt-get update && apt-get install -y zlib1g-dev libpng-dev libzip-dev\
    && docker-php-ext-install pdo pdo_mysql mysqli zip gd
RUN a2enmod rewrite

RUN apt-get install -y --no-install-recommends \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libxpm-dev \
    libvpx-dev \
&& docker-php-ext-configure gd \
    --with-xpm=/usr/include/ \
    --with-jpeg=/usr/include/ \
    --with-freetype=/usr/include/ \
&& docker-php-ext-install gd

RUN apt-get update -y
RUN apt-get install -y libmcrypt-dev
RUN pecl install mcrypt-1.0.5

RUN apt-get install -y \
      ca-certificates \
      unzip

ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN docker-php-ext-configure opcache --enable-opcache \
    && docker-php-ext-install opcache
