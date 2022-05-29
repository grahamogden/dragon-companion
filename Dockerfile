FROM php:7.4-apache
WORKDIR /var/www/html

#COPY ./build/config/fastcgi.conf /etc/nginx/conf.d/fastcgi.conf

RUN apt-get update
#RUN apt-get upgrade --assume-yes --quiet
#RUN apt-get dist-upgrade --assume-yes --quiet
#RUN apt-get autoclean
#RUN apt-get clean
RUN apt install -y nano
#RUN apt install php-intl

#RUN mkdir /var/www/html/dragon-companion

RUN a2enmod rewrite
COPY ./build/sites-available/dragon-companion.conf /etc/apache2/sites-available/dragon-companion.conf
RUN a2ensite dragon-companion.conf

RUN docker-php-ext-install mysqli pdo pdo_mysql

RUN apt-get install -y libicu-dev
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-enable intl

#RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
#RUN cp /usr/local/etc/php/php.ini-production /etc/php/php.ini
#        echo "extension=\"php_intl.dll\"" >> /usr/local/etc/php/php.ini

RUN service apache2 restart

EXPOSE 80
