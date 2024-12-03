FROM php:8.1.12-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN apt-get update -y && apt-get install -y openssl zip unzip git libxslt1-dev 
RUN docker-php-ext-install pdo pdo_mysql xsl 
RUN echo 'pm.max_children = 25' >> /usr/local/etc/php-fpm.d/zz-docker.conf

WORKDIR /backend
COPY . .
RUN composer install --optimize-autoloader --no-dev
RUN chown -R www-data:www-data /backend/storage


## Consider uninstalling some pacakges to cut down on image size:
## https://stackoverflow.com/questions/65554220/trying-to-add-libxslt-to-docker-container