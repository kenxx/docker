FROM php:7.2-fpm

ARG SOURCE
ARG COMPOSER=https://getcomposer.org/installer
ARG COMPOSER_ADDR=https://packagist.phpcomposer.com
ARG XDEBUG=1
ARG SWOOLE=1

# set apt repos
RUN mkdir /var/www/.composer && chown www-data:www-data /var/www/.composer; \
#	if [ ${SOURCE_REPLACE} ]; then \
#		sed -i "s/${SOURCE}/${SOURCE_REPLACE}/g" /etc/apt/sources.list; \
#		cat /etc/apt/sources.list; \
#	fi
	\
	curl -sS ${COMPOSER} | php; \
	mv composer.phar /usr/local/bin/composer; \
	chmod +x /usr/local/bin/composer; \
	composer -V; \
	if [ ${COMPOSER_ADDR} ]; then \
		composer config -g repo.packagist composer ${COMPOSER_ADDR}; \
	fi

RUN set -ex; \
	\
	savedAptMark="$(apt-mark showmanual)"; \
	\
	apt-get update; \
	apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libxml2-dev \
		libmemcached-dev \
        libpng-dev; \
	\
    docker-php-ext-install -j$(nproc) mcrypt pdo_mysql simplexml sockets mysqli zip; \
    docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/; \
    docker-php-ext-install -j$(nproc) gd; \
	\
	pecl install igbinary-2.0.5 msgpack-2.0.2; \
	docker-php-ext-enable igbinary msgpack; \
	pecl install mongodb-1.4.3 redis-4.0.2; \
	docker-php-ext-enable mongodb redis; \
	if [ ${XDEBUG} ]; then \
		pecl install xdebug-2.6.0; \
		docker-php-ext-enable xdebug; \
	fi; \
	if [ ${SWOOLE} ]; then \
		pecl install swoole-2.2.0; \
		docker-php-ext-enable swoole; \
	fi; \
	\
	pecl download memcached-3.0.4 \
	&& tar xf memcached-3.0.4.tgz \
	&& rm memcached-3.0.4.tgz \
	&& ( \
		cd memcached-3.0.4 \
		&& phpize \
		&& ./configure --enable-memcached-igbinary \
		&& make -j$(nproc) \
		&& make install \
	) \
	&& rm -r memcached-3.0.4 \
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

