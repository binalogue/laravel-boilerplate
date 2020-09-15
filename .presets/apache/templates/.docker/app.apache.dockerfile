FROM php:7.4-apache

ENV PATH="./vendor/bin:${PATH}" \
  PHP_OPCACHE_VALIDATE_TIMESTAMPS="0" \
  PHP_OPCACHE_MAX_ACCELERATED_FILES="12000" \
  PHP_OPCACHE_MEMORY_CONSUMPTION="256"

# Enable Apache mod_rewrite.
RUN a2enmod rewrite

# Install Linux packages.
RUN apt-get update \
  && apt-get install -y --no-install-recommends \
  gifsicle \
  git \
  jpegoptim \
  libjpeg62-turbo-dev \
  libmagickwand-dev \
  libpng-dev \
  libwebp-dev \
  libzip-dev \
  optipng \
  pngquant \
  procps \
  sqlite3 \
  unzip \
  wget

# Install Node.js and some global dependencies.
RUN wget -qO- https://deb.nodesource.com/setup_12.x | bash - && apt-get install -y nodejs
RUN npm install -g yarn

# Install Docker PHP extensions.
RUN docker-php-ext-configure gd --with-webp=/usr/include/ --with-jpeg=/usr/include/
RUN docker-php-ext-install \
  bcmath \
  exif \
  gd \
  opcache \
  pcntl \
  pdo \
  pdo_mysql \
  zip
RUN pecl install \
  apcu \
  imagick-3.4.3 \
  redis \
  xdebug
RUN docker-php-ext-enable \
  apcu \
  imagick \
  redis \
  xdebug

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

# Copy the application.
COPY . /var/www

# Install Composer.
# We need to run this command after "Copy the application" because we need the
# `composer.json` file.
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN chmod +x /usr/local/bin/composer-installer \
  && /usr/local/bin/composer-installer \
  && mv composer.phar /usr/local/bin/composer \
  && chmod +x /usr/local/bin/composer \
  && composer check-platform-reqs --working-dir=/var/www/ \
  && composer global require hirak/prestissimo --prefer-dist --no-progress --no-suggest --classmap-authoritative \
  && composer clear-cache \
  && composer --version

# Set server permissions.
RUN chown -R www-data:www-data /var/www/

# Add alias.
RUN echo 'alias pa="php artisan"' >> ~/.bashrc

EXPOSE 80

# Run app.
CMD ["/usr/local/bin/run-app"]
