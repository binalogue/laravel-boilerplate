FROM php:7.3-apache-stretch

ENV PATH="./vendor/bin:${PATH}" \
  PHP_OPCACHE_VALIDATE_TIMESTAMPS="0" \
  PHP_OPCACHE_MAX_ACCELERATED_FILES="8000" \
  PHP_OPCACHE_MEMORY_CONSUMPTION="128"

# Enable Apache mod_rewrite.
RUN a2enmod rewrite

# Install some packages.
RUN apt-get update \
  && apt-get install -y --no-install-recommends \
  procps \
  sqlite3

# Install MySQL, Opcache and other PHP extensions.
RUN docker-php-ext-install \
  mbstring \
  opcache \
  pdo \
  pdo_mysql

# Install XDebug.
RUN pecl install apcu xdebug \
  && docker-php-ext-enable apcu xdebug

# Copy PHP config files.
COPY .docker/php/composer-installer.sh /usr/local/bin/composer-installer
COPY .docker/php/conf.d/*.ini /usr/local/etc/php/conf.d/
COPY .docker/php/php.ini /usr/local/etc/php/php.ini

# Copy Apache config files.
COPY .docker/apache/vhost.conf /etc/apache2/sites-available/000-default.conf

# Copy a custom script for Laravel.
COPY .docker/app.apache.sh /usr/local/bin/run-app

# Set some file permissions.
RUN chmod +x /usr/local/bin/confd \
  && chmod +x /usr/local/bin/run-app

# Install Composer.
RUN chmod +x /usr/local/bin/composer-installer \
  && /usr/local/bin/composer-installer \
  && mv composer.phar /usr/local/bin/composer \
  && chmod +x /usr/local/bin/composer \
  && composer --version

# Copy the application.
COPY . /var/www

# Set Apache permissions.
RUN chown -R www-data:www-data /var/www

EXPOSE 80

# Run app.
CMD ["/usr/local/bin/run-app"]
