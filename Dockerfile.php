# Set the wanted PHP versions
ARG PHP_VERSION=8.1.0
ARG PHP_BASE_IMAGE=fpm

# Get PHP with its Docker image
FROM php:${PHP_VERSION}-${PHP_BASE_IMAGE}

RUN docker-php-ext-install bz2 && \
    docker-php-ext-configure gd \
    --with-freetype-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ && \
    docker-php-ext-install gd && \
    docker-php-ext-install iconv && \
    docker-php-ext-install opcache && \
    docker-php-ext-install pdo && \
    docker-php-ext-install pdo_mysql && \
    docker-php-ext-install zip


# Install Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/ \
    && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer
ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"

# Expose ports
EXPOSE 80
EXPOSE 443

# Set the default command to execute
# when creating a new container
CMD service nginx start