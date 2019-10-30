FROM alpine:latest

ARG BROOK_VERSION=v20190601

WORKDIR /root

RUN set -ex; \
    \
    sed -i 's/dl-cdn.alpinelinux.org/mirrors.aliyun.com/g' /etc/apk/repositories; \
    \
    apk add --no-cache --virtual .persistent-deps \
    curl; \
    \
    curl -L -e '; auto' -o "brook" "https://github.com/txthinking/brook/releases/download/${BROOK_VERSION}/brook";

ENTRYPOINT ["/root/brook"]

