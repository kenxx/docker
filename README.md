# docker

Some useful `Dockerfile`.

## ss-go

`ss-go` server.

## jbls

`jbls` server.

## php

modified php:7.1-fpm-jessie

```Dockerfile
# will override apt mirrors
ARG SOURCE
# will set composer installer location
ARG COMPOSER=https://getcomposer.org/installer
# will set packagist mirror
ARG COMPOSER_ADDR=https://packagist.phpcomposer.com
# will install xdebug-2.6.0
ARG XDEBUG=2.6.0
# will install swoole-2.2.0
ARG SWOOLE=2.2.0
```

# docker-compose

Some dockers managed by docker-compose.

## STACK - develop

stack

1. php:7.2-fpm
2. nginx:latest
3. mysql:5.7
4. redis:latest
5. mongo:latest
6. memcached:latest

exposed port

```
php: 9000
nginx: 80, 443
mysql: 3306
redis: 6379
mongo: 27017
memcached: 11211
```

## STACK - production

stack

1. php:7.2-fpm
2. nginx:latest
3. mysql:5.7
4. redis:latest
5. mongo:latest
6. memcached:latest

exposed port

```
nginx: 80, 443
```

## STACK - project

stack

1. gogs
2. drone

exposed port

```
gogs: 3000
drone: 8000
```
