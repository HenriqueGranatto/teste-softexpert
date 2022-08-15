FROM php:8.1

WORKDIR /var/www

# Instala as dependências
RUN apt-get update
RUN apt-get install -y libpq-dev
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install pdo pgsql pdo_pgsql

# COPIA O CÓDIGO FONTE PARA A IMAGEM
ADD . .

# Expõe a porta do PHP-FPM
EXPOSE 8080