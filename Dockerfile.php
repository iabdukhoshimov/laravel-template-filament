FROM php:8.2-fpm

RUN apt-get update && \
    apt-get -y install \
        gnupg2 && \
    apt-get install -y gettext-base && \
    apt-key update && \
    apt-get update && \
    apt-get -y install \
            g++ \
            git \
            curl \
            cron \
            wget \
            libcurl3-dev \
            libicu-dev \
            libfreetype6-dev \
            libjpeg-dev \
            libjpeg62-turbo-dev \
            libonig-dev \
            libmagickwand-dev \
            libpq-dev \
            libpng-dev \
            libxml2-dev \
            libzip-dev \
            zlib1g-dev \
            default-mysql-client \
            openssh-client \
            nano \
            unzip \
            libcurl4-openssl-dev \
            libssl-dev \
        --no-install-recommends && \
        apt-get clean && \
	rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install \
                            soap \
                            zip \
                            curl \
                            bcmath \
                            exif \
                            gd \
                            iconv \
                            intl \
                            mbstring \
                            opcache \
                            pdo_mysql \
                            pdo_pgsql \
    && docker-php-ext-configure bcmath

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg

WORKDIR /app

COPY . /app
COPY /.env ./.env


# COPY ./docker/php/overrides.ini /etc/php/8.2/fpm/conf.d/99-overrides.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN composer update --ignore-platform-req=ext-sockets --no-plugins --no-scripts

RUN chown -R $USER:www-data storage && \
    chown -R $USER:www-data bootstrap/cache && \
    chmod -R 775 storage && \
    chmod -R 775 bootstrap/cache && \
    composer update --ignore-platform-req=ext-sockets --no-plugins --no-scripts


EXPOSE 9000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
