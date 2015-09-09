FROM php:7-fpm

# Install the zip extension for composer
RUN apt-get update && apt-get install -y zlib1g-dev \
    && docker-php-ext-install zip

# Set up production config
RUN echo 'error_reporting = E_ALL' >> /usr/local/etc/php/php.ini
RUN echo 'display_errors = Off' >> /usr/local/etc/php/php.ini
RUN echo 'date.timezone = "UTC"' >> /usr/local/etc/php/php.ini
RUN echo 'cgi.fix_pathinfo=1' >> /usr/local/etc/php/php.ini
RUN echo 'expose_php = Off' >> /usr/local/etc/php/php.ini
RUN echo 'default_mimetype = "text/plain"' >> /usr/local/etc/php/php.ini
RUN echo 'display_errors = Off' >> /usr/local/etc/php/php.ini
RUN echo 'memory_limit = 256M' >> /usr/local/etc/php/php.ini
RUN echo 'max_execution_time = 3' >> /usr/local/etc/php/php.ini

# Download and run Composer
RUN apt-get update && apt-get install -y wget
RUN wget -qO- https://getcomposer.org/installer | php -- --filename=composer --install-dir=/usr/local/sbin
RUN apt-get remove -y --purge wget
RUN apt-get clean

ADD . /var/www/html
RUN /usr/local/sbin/composer update --prefer-source --no-dev --optimize-autoloader --no-interaction