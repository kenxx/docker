FROM alpine:latest

RUN set -ex; \
    \
    sed -i 's#http://dl-cdn.alpinelinux.org#https://mirrors.aliyun.com#g' /etc/apk/repositories; \
    \
    apk add --no-cache --virtual .persistent-deps \
        openssh \
        bash \
        git \
        tar; \
    mkdir /usr/local/syncd

COPY ./output /usr/local/syncd

RUN ln -s /usr/local/syncd/bin/syncd /usr/local/bin/syncd

WORKDIR /usr/local/syncd/bin

CMD [ "syncd", "-c", "/usr/local/syncd/etc/syncd.ini" ]

