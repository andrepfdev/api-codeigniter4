#!/bin/bash

# Garantir permissões corretas para writable e seus subdiretórios
chown -R www-data:www-data /var/www/html
find /var/www/html/writable -type d -exec chmod 775 {} \;
find /var/www/html/writable -type f -exec chmod 664 {} \;

# Executar o comando fornecido (apache2-foreground)
exec "$@"
