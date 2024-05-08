FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN docker-php-ext-enable mysqli

# Habilitar la extensión mysqli
RUN docker-php-ext-enable mysqli

# Instalar Composer
RUN apt-get update && \
    apt-get install -y --no-install-recommends git zip unzip && \
    rm -r /var/lib/apt/lists/* && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# # Configurar el directorio de trabajo
WORKDIR /var/www/html

# # Instalar Laravel usando Composer
# RUN composer create-project --prefer-dist laravel/laravel .
# COPY . /var/www/html

# # Configurar los permisos adecuados para Laravel
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# # Habilitar el módulo de reescritura de Apache para Laravel
# RUN a2enmod rewrite

# # Reiniciar Apache
# RUN service apache2 restart
