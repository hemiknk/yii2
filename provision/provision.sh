#!/bin/bash

DIR="$( cd "$( dirname "$0" )" && pwd )"
SITE_DOMAIN="yii2template.lo.com"
PROVISION_DIR="/vagrant"
MYSQL_USER="root"
MYSQL_PASSWORD="root"

echo "--- Provision dir: $DIR ---"

# colorize
sed -i 's/#force_color_prompt=yes/force_color_prompt=yes/g' /home/vagrant/.bashrc

# locale
export LANGUAGE=en_US.UTF-8
export LANG=en_US.UTF-8
export LC_ALL=en_US.UTF-8

start=`date +%s`

export DEBIAN_FRONTEND=noninteractive

# For latest nginx
add-apt-repository -y ppa:nginx/stable

# For latest php 5.7
sudo add-apt-repository -y ppa:ondrej/mysql-5.7

echo "--- Update system ---"
apt-get update

echo -e "--- Install MySQL and settings ---"

debconf-set-selections <<< 'mysql-server mysql-server/root_password password '$MYSQL_USER
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password '$MYSQL_PASSWORD
apt-get -y install mysql-server

echo "--- Restart mysql deamon ---"
systemctl restart mysql

echo "--- Install system packages ---"
apt-get -q -y  -o Dpkg::Options::=--force-confnew  install \
    curl \
    htop \
    git \
    make \
    vim \
    g++ \
    build-essential \
    php \
    php7.0-mysql \
    php7.0-mcrypt \
    php7.0-gd \
    php7.0-intl \
    php-xdebug \
    php7.0-cli \
    php7.0-common \
    php7.0-fpm \
    php7.0-curl \
    php7.0-xsl \
    php-pear \
    php7.0-dev \
    nginx \
    mc \
    links \
    tree \
    php-mbstring \

echo "--- Setup xdebug ---"
pecl install xdebug >> /dev/null 2>&1

echo "--- Conpy php settings ---"
cp -v $PROVISION_DIR/provision/php/7.0/extensions/xdebug.ini /etc/php/7.0/mods-available/xdebug.ini
cp -v $PROVISION_DIR/provision/php/7.0/extensions/mcrypt.ini /etc/php/7.0/mods-available/mcrypt.ini
cp -v $PROVISION_DIR/provision/php/cli.php.ini /etc/php/7.0/cli/php.ini
cp -v $PROVISION_DIR/provision/php/php.ini /etc/php/7.0/fpm/php.ini
cp -v $PROVISION_DIR/provision/php/php-fpm.conf /etc/php/7.0/fpm/php-fpm.conf
cp -v $PROVISION_DIR/provision/php/www.conf /etc/php/7.0/fpm/pool.d/www.conf

systemctl restart php7.0-fpm 

cp -v $PROVISION_DIR/provision/nginx/nginx.conf /etc/nginx/nginx.conf
cp -v $PROVISION_DIR/provision/nginx/conf.d/* /etc/nginx/conf.d

mkdir -v -p /etc/nginx/sites-available
mkdir -v -p /etc/nginx/sites-enabled
rm /etc/nginx/sites-enabled/default
cp -v $PROVISION_DIR/provision/nginx/$SITE_DOMAIN.conf /etc/nginx/sites-available/$SITE_DOMAIN
ln -s /etc/nginx/sites-available/$SITE_DOMAIN /etc/nginx/sites-enabled/$SITE_DOMAIN

systemctl restart nginx 

# Drop and create again database for development and tests
mysql -uroot -proot -e "drop database if exists site; create database site; GRANT ALL ON site.* TO 'vagrant'@'%' IDENTIFIED BY 'vagrant'; FLUSH PRIVILEGES;"
mysql -uroot -proot -e "drop database if exists site_test; create database site_test; GRANT ALL ON site_test.* TO 'vagrant'@'%' IDENTIFIED BY 'vagrant'; FLUSH PRIVILEGES;"

echo "-- Install composer globaly --"
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

echo "--- Add github access token to composer config ---"
if [ -f $PROVISION_DIR/provision/composer/set-github-oauth-token.sh ]
then
    $PROVISION_DIR/provision/composer/set-github-oauth-token.sh
fi

echo "--- Check versions ---"
echo `lsb_release -a`
echo `nginx -v`
echo `mysql --version`
echo `php -v`

echo "--- Create database. Import dump ---"
mysqladmin -u$MYSQL_USER -p$MYSQL_PASSWORD create vagrant_yii2_template
mysql -u$MYSQL_USER -p$MYSQL_PASSWORD vagrant_yii2_template < /vagrant/dump.sql

echo "--- Ready to go ---"

end=`date +%s`

provisionTime=$((end - start))

echo "Provision took: '$provisionTime' seconds"
