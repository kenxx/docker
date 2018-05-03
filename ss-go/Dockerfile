FROM alpine

RUN apk add --no-cache --virtual .persistent-deps \
		curl

RUN mkdir /ss-go

WORKDIR /ss-go

RUN curl -s -L -e '; auto' -o "shadowsocks-server.tar.gz" "https://github.com/shadowsocks/shadowsocks-go/releases/download/1.2.1/shadowsocks-server.tar.gz"

RUN tar xf shadowsocks-server.tar.gz

ENTRYPOINT ["/ss-go/shadowsocks-server"]

