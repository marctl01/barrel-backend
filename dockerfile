# Utiliza una imagen base de PHP con Apache
FROM php:8.1-apache

# Copia los archivos de tu proyecto al directorio de trabajo del contenedor
COPY . /var/www/html/

# Establece el directorio de trabajo
WORKDIR /var/www/html/

# Instala las dependencias necesarias
RUN apt-get update \
    && apt-get install -y \
        libzip-dev \
        zip \
    && docker-php-ext-install zip \
    && a2enmod rewrite

# Copia la configuración del sitio de Apache
COPY docker/apache/site.conf /etc/apache2/sites-available/000-default.conf

# Habilita el acceso al directorio /var/www/html
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Exponer el puerto 80 del contenedor
EXPOSE 80

# Comando de inicio del servidor Apache
CMD ["apache2-foreground"]
