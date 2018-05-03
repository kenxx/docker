# docker

Some useful `Dockerfile`.

## ss-go

`ss-go` server.

## jbls

`jbls` server.

# docker-compose

Some dockers managed by docker-compose.

## STACK - develop

stack

1. php:7.1-fpm
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

1. php:7.1-fpm
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
