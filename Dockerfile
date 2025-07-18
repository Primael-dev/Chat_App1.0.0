# Utilise l'image officielle PHP avec Apache
FROM php:8.2-apache

# Active les extensions nécessaires
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copie le projet dans le dossier web
COPY . /var/www/html/

# Active le module rewrite
RUN a2enmod rewrite

# Copie la configuration personnalisée d'Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Donne les bons droits
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html
