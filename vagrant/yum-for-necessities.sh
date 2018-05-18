#!/bin/bash
cd /tmp
wget -q http://rpms.remirepo.net/enterprise/remi-release-7.rpm
wget -q https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm
rpm -Uvh remi-release-7.rpm epel-release-latest-7.noarch.rpm
yum-config-manager --enable remi-php71
yum install php -y
yum install php-devel
yum install php-pear
yum install gcc gcc-c++ autoconf automake
yum install php-pecl-zip -y
yum install php-intl -y

cd /tmp/
sudo curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

mysql -uroot -ppassword -e "CREATE DATABASE IF NOT EXISTS symfony_blog"

yum install composer -y
yum install nodejs -y
npm install yarn -g

cd /var/www/html/
/usr/local/bin/composer install

systemctl enable httpd.service
mv /etc/localtime /etc/localtime.bak
ln -s /usr/share/zoneinfo/Europe/Zagreb /etc/localtime

php /var/www/html/bin/console ckeditor:install
php /var/www/html/bin/console assets:install web
php /var/www/html/bin/console doctrine:schema:update --force
php /var/www/html/bin/console fos:user:create admin admin@example.com password --super-admin



