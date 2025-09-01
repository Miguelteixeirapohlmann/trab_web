# Use a imagem oficial do PHP com Apache
FROM php:8.2-apache

# Instale extensões necessárias (exemplo: mysqli para MySQL)
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copie os arquivos do projeto para o diretório padrão do Apache
COPY . /var/www/html/

# Dê permissão para o Apache acessar os arquivos
RUN chown -R www-data:www-data /var/www/html

# Exponha a porta padrão do Apache
EXPOSE 80

# Ative o módulo de reescrita do Apache (se necessário)
RUN a2enmod rewrite

# Inicie o Apache em primeiro plano
CMD ["apache2-foreground"]
