FROM alpine

RUN set -ex; \
    apk add --no-cache --virtual .persistent-deps \
		curl; \
    cd /tmp; \
    curl -s -L -e '; auto' -o "shadowsocks.tar.xz" "https://github.com/shadowsocks/shadowsocks-rust/releases/download/v1.8.23/shadowsocks-v1.8.23.x86_64-unknown-linux-musl.tar.xz"; \
    tar xf "shadowsocks.tar.xz"; \
    rm "shadowsocks.tar.xz"; \
    chown root:root sslocal ssmanager ssserver ssurl; \
    mv sslocal ssmanager ssserver ssurl /usr/local/bin

CMD [ "ssserver" ]