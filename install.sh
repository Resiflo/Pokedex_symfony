#!/bin/bash

apt install -y sudo nginx php-fpm sqlite3 php-sqlite3 php-zip unzip php-xml git
apt-get install php php-fpm php-common php-mysql php-gmp php-curl php-intl php-mbstring php-xmlrpc php-gd php-bcmath php-soap php-ldap php-imap php-xml php-cli php-zip -y

cd /var/www/html

# composer
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
mv composer.phar /usr/local/bin/composer
git clone "https://github.com/Resiflo/Pokedex_symfony" /var/www/html/projetweb


cd projetweb

composer install

cat .env.testu > .env

php bin/console d:d:c

php bin/console m:migration

php bin/console d:m:m

cat nginx.conf > /etc/nginx/sites-available/default

systemctl restart nginx

chown www-data:www-data -R /var/www/html/projetweb/