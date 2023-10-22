FROM php:8.2-apache
LABEL maintainer="Lucas Pereira <lucaspereira-dev@outlook.com>"
WORKDIR /var/www/html/
ENV TZ America/Sao_Paulo

# Ativar o módulo rewrite do Apache
RUN a2enmod rewrite

# Baixando depedências
RUN apt update; \
    apt install -y libxml2-dev locales curl libzip-dev unzip; \
    apt clean; \
    rm -rf /var/lib/apt/lists/*;

RUN sed -i '/pt_BR.UTF-8/s/^# //g' /etc/locale.gen; \
    sed -i '/pt_BR.ISO-8859-1/s/^# //g' /etc/locale.gen; \
    sed -i '/es_ES.UTF-8/s/^# //g' /etc/locale.gen; \
    sed -i '/en_US.UTF-8/s/^# //g' /etc/locale.gen; \
    locale-gen;

RUN docker-php-ext-install -j "$(nproc --all)" pdo pdo_mysql gd zip dom xml intl; \
    rm -rf /tmp/pear;

# Download do composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Intalação do xdebug
RUN pecl install -o -f xdebug && docker-php-ext-enable xdebug
RUN docker-php-ext-enable xdebug

COPY . /var/www/html
