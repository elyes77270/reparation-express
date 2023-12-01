FROM php:8.2-apache

ENV COMPOSER_ALLOW_SUPERUSER=1

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions pdo_pgsql intl

RUN curl -sSk https://getcomposer.org/installer | php -- --disable-tls && \
   mv composer.phar /usr/local/bin/composer

# Configure Node.js repository and install Node.js 16
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | bash -
RUN apt-get update && apt-get install -y nodejs npm

RUN apt-get install git -y

COPY . /var/www/html/

COPY ./apache.conf /etc/apache2/sites-available/000-default.conf

RUN cd /var/www/html && \
    composer install && \
    npm install --force && \
    npm run build

# Move the installation of wkhtmltopdf after configuring Apache
RUN apt-get install wkhtmltopdf -y

WORKDIR /var/www/html/

ENTRYPOINT ["bash", "./docker.sh"]

EXPOSE 80