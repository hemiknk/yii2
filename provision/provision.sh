#!/bin/bash

DIR="$( cd "$( dirname "$0" )" && pwd )"
SITE_DOMAIN="site.dev"
PROVISION_DIR="/var/www/$SITE_DOMAIN"

echo "Provision dir: $DIR"

# colorize
sed -i 's/#force_color_prompt=yes/force_color_prompt=yes/g' /home/vagrant/.bashrc

# locale
export LANGUAGE=en_US.UTF-8
export LANG=en_US.UTF-8
export LC_ALL=en_US.UTF-8

start=`date +%s`

export DEBIAN_FRONTEND=noninteractive

# For latest nginx 1.8
apt-get purge -y nginx nginx-common
add-apt-repository -y ppa:nginx/stable

# For latest php 5.5
#add-apt-repository ppa:ondrej/php5-5.6

# For latest php 5.7
#sudo add-apt-repository -y ppa:ondrej/mysql-5.7

# For latest redis
#add-apt-repository ppa:chris-lea/redis-server

apt-get update

# Set mysql root password
debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'

apt-get -y install mysql-server

cp -v "$PROVISION_DIR/provision/mysql/my.cnf" /etc/mysql/my.cnf
#systemctl restart mysql

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

# Setup xdebug
pecl install xdebug

cp -v $PROVISION_DIR/provision/php/7.0/extensions/xdebug.ini /etc/php/7.0/mods-available/xdebug.ini
#php5enmod xdebug
# Setup xdebug

cp -v $PROVISION_DIR/provision/php/7.0/extensions/mcrypt.ini /etc/php/7.0/mods-available/mcrypt.ini
#php5enmod mcrypt

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

# Install nodejs
#curl -sL https://deb.nodesource.com/setup_0.12 | sudo bash -
#apt-get -q -y  -o Dpkg::Options::=--force-confnew  install \
#    nodejs

# Install composer globaly
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Add github access token to composer config
if [ -f $PROVISION_DIR/provision/composer/set-github-oauth-token.sh ]
then
    $PROVISION_DIR/provision/composer/set-github-oauth-token.sh
fi

# Check versions
echo `lsb_release -a`
echo `nginx -v`
echo `mysql --version`
echo `php -v`
#echo `node -v`
#echo `npm -v`

# Insatll package for compiling native extensions
#npm install -g node-gyp

# Install globally bower and gulp
#npm install -g bower gulp

echo "Ready to go"

end=`date +%s`

provisionTime=$((end - start))

echo "Provision took: '$provisionTime' seconds"
