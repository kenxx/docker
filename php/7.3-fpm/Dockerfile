FROM php:7.3-fpm

ARG SOURCE=
ARG COMPOSER=https://getcomposer.org/installer
#https://packagist.phpcomposer.com
ARG COMPOSER_MIRROR=
#2.6.1
ARG XDEBUG=
#4.2.13
ARG SWOOLE=

WORKDIR /var/php

RUN if [ ${SOURCE} ]; then \
# set up Chinese mirror
		sed -i "s#http://deb.debian.org/#${SOURCE}#g" /etc/apt/sources.list; \
		sed -i "s#http://security.debian.org/#${SOURCE}#g" /etc/apt/sources.list; \
		sed -i "s#http://deb.debian.org/#${SOURCE}#g" /etc/apt/sources.list.d/buster.list; \
		sed -i "s#http://security.debian.org/#${SOURCE}#g" /etc/apt/sources.list.d/buster.list; \
		cat /etc/apt/sources.list; \
	fi; \
	\
	if [ ${COMPOSER} ]; then \
# Set composer
		mkdir /var/php/.composer -p; \
		chown www-data:www-data /var/php/.composer; \
		curl -sS ${COMPOSER} | php; \
		mv composer.phar /usr/local/bin/composer; \
		chmod +x /usr/local/bin/composer; \
		composer -V; \
		if [ ${COMPOSER_MIRROR} ]; then \
			composer config -g repo.packagist composer ${COMPOSER_MIRROR}; \
		fi; \
	fi

RUN set -ex; \
	\
	savedAptMark="$(apt-mark showmanual)"; \
	\
	apt-get update; \
	apt-get install -y \
# for memcached
		zlib1g-dev \
		libmemcached-dev \
# for gd
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
# others
		libzip-dev \
        libmcrypt-dev; \
	\
    docker-php-ext-install -j$(nproc) pdo_mysql sockets mysqli zip pcntl; \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/; \
    docker-php-ext-install -j$(nproc) gd; \
	\
	pecl install mongodb redis; \
	docker-php-ext-enable mongodb redis; \
	if [ ${XDEBUG} ]; then \
		pecl install xdebug-${XDEBUG}; \
		docker-php-ext-enable xdebug; \
	fi; \
	if [ ${SWOOLE} ]; then \
		pecl install swoole-${SWOOLE}; \
		docker-php-ext-enable swoole; \
	fi; \
	\
	pecl install igbinary msgpack \
	&& docker-php-ext-enable igbinary msgpack \
	&& MEMCACHED=3.1.3 \
	&& pecl download memcached-${MEMCACHED} \
	&& tar xf memcached-${MEMCACHED}.tgz \
	&& rm memcached-${MEMCACHED}.tgz \
	&& ( \
		cd memcached-${MEMCACHED} \
		&& phpize \
		&& ./configure --enable-memcached-igbinary --enable-memcached-msgpack \
		&& make -j$(nproc) \
		&& make install \
	) \
	&& rm -r memcached-${MEMCACHED} \
	&& docker-php-ext-enable memcached; \
	\
# reset apt-mark's "manual" list so that "purge --auto-remove" will remove all build dependencies
	apt-mark auto '.*' > /dev/null; \
	apt-mark manual $savedAptMark; \
	ldd "$(php -r 'echo ini_get("extension_dir");')"/*.so \
		| awk '/=>/ { print $3 }' \
		| sort -u \
		| xargs -r dpkg-query -S \
		| cut -d: -f1 \
		| sort -u \
		| xargs -rt apt-mark manual; \
	\
	apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false; \
	rm -rf /var/lib/apt/lists/*

# set recommended PHP.ini settings
# see https://secure.php.net/manual/en/opcache.installation.php
RUN { \
		echo 'opcache.memory_consumption=128'; \
		echo 'opcache.interned_strings_buffer=8'; \
		echo 'opcache.max_accelerated_files=4000'; \
		echo 'opcache.revalidate_freq=2'; \
		echo 'opcache.fast_shutdown=1'; \
		echo 'opcache.enable_cli=1'; \
	} > /usr/local/etc/php/conf.d/opcache-recommended.ini

