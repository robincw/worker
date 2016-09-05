FROM php:7.0-cli
RUN apt-get update
RUN apt-get install -y \
    python \
    git

RUN cd /usr/local/src \
 && git clone https://github.com/edenhill/librdkafka.git \
 && cd librdkafka \
 && ./configure \
 && make \
 && make install

RUN cd /usr/local/src \
 && git clone https://github.com/arnaud-lb/php-rdkafka.git \
 && cd php-rdkafka \
 && git checkout php7 \
 && phpize \
 && ./configure \
 && make all -j 5 \
 && make install

RUN echo 'extension=/usr/local/lib/php/extensions/no-debug-non-zts-20151012/rdkafka.so' >/usr/local/etc/php/conf.d/rdkafka.ini
RUN php -i |grep --color rdkafka

RUN mkdir -p /opt/phpkafka-worker
