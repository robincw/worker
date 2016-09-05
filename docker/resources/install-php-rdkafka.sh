#!/bin/bash
cd /usr/local/src
git clone https://github.com/edenhill/librdkafka.git
cd librdkafka
./configure
make
make install

cd /usr/local/src
git clone https://github.com/arnaud-lb/php-rdkafka.git
cd php-rdkafka
git checkout php7
phpize
./configure
make all -j 5
make install

ls -l /usr/local/lib/php/extensions/no-debug-non-zts-20151012/rdkafka.so

echo 'extension=/usr/local/lib/php/extensions/no-debug-non-zts-20151012/rdkafka.so' >/usr/local/etc/php/conf.d/rdkafka.ini
php -i |grep kafka
