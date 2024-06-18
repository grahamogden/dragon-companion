FROM php:8.1-apache
WORKDIR /var/www

#COPY ./build/config/fastcgi.conf /etc/nginx/conf.d/fastcgi.conf

RUN apt-get update
#RUN apt-get upgrade --assume-yes --quiet
#RUN apt-get dist-upgrade --assume-yes --quiet
# RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
RUN apt-get autoclean
RUN apt-get clean
RUN apt install -y nano
# RUN apt-get install -y nodejs
# RUN apt-get install -y npm
# ADD package.json /tmp/package.json

# RUN nvm install --lts
# RUN npm install --save-dev
# RUN cd /tmp && npm install --save-dev

# RUN npm install -g yo generator-tinymce --unsafe-perm=true --allow-root
# RUN #npm install -g typescript
# RUN #npm install -g  --save-devwebpack webpack-cli
# RUN #npm install -D @webpack-cli/generators
# RUN #npm install -g ts-loader source-map-loader
#RUN apt install php-intl

#RUN mkdir /var/www/html/dragon-companion

# Install Xdebug
RUN pecl install xdebug
# && docker-php-ext-enable xdebug

# Copy custom xdebug.ini configuration
COPY ./build/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Apache rewrite configuration
RUN a2enmod rewrite
RUN a2enmod headers
COPY ./build/sites-available/dragon-companion.conf /etc/apache2/sites-available/dragon-companion.conf

# SSL Certificates and private keys
RUN a2enmod ssl
COPY ./build/certs/dragon-companion.crt /etc/ssl/certs/dragon-companion.crt
COPY ./build/private/dragon-companion.key /etc/ssl/private/dragon-companion.key

# Configure site
RUN a2ensite dragon-companion.conf

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get install -y libicu-dev
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-enable intl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# RUN composer install --dev

#RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
#RUN cp /usr/local/etc/php/php.ini-production /etc/php/php.ini
#        echo "extension=\"php_intl.dll\"" >> /usr/local/etc/php/php.ini

RUN service apache2 restart

EXPOSE 80
