FROM php:8.1-apache

# Instalar dependências
RUN apt-get update && apt-get install -y \
    libicu-dev \
    zip \
    unzip

# Instalar extensões PHP necessárias
RUN docker-php-ext-install \
    intl \
    pdo_mysql \
    mysqli

# Habilitar mod_rewrite do Apache
RUN a2enmod rewrite

# Configurar diretório de trabalho
WORKDIR /var/www/html

# Copiar arquivos do projeto
COPY . /var/www/html/

# Criar arquivo de configuração do Apache
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    DirectoryIndex index.php\n\
    <Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
    </Directory>\n\
    </VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Configurar permissões (atualizado)
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html/writable -type d -exec chmod 775 {} \; \
    && find /var/www/html/writable -type f -exec chmod 664 {} \;

# Adicionar script de inicialização
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]

# Expor porta 80
EXPOSE 80
