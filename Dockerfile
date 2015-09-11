FROM php:7-fpm

# Install the zip extension for composer
RUN apt-get update && apt-get install -y zlib1g-dev \
    && docker-php-ext-install zip

# Without this, errors will not be logged to stderr
RUN echo 'catch_workers_output = yes' >> /usr/local/etc/php-fpm.conf

ADD php.ini /usr/local/etc/php/php.ini

# Download and run Composer
RUN apt-get update && apt-get install -y wget
RUN wget -qO- https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/sbin
RUN apt-get remove -y --purge wget
RUN apt-get clean

ADD . /var/www/html
RUN chown -R www-data:www-data /var/www/html
RUN /usr/local/sbin/composer update --prefer-source --no-dev --optimize-autoloader --no-interaction