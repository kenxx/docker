FROM alpine

ENV SS_RUST_URL="https://github.com/shadowsocks/shadowsocks-rust/releases/download/v1.8.23/shadowsocks-v1.8.23.x86_64-unknown-linux-musl.tar.xz"

RUN set -eux; \
    apk add --no-cache --virtual .persistent-deps \
		curl; \
    cd /tmp; \
    FILENAME="shadowsocks.tar.xz"; \
    curl -fsSL -o $FILENAME "$SS_RUST_URL"; \
    tar xf $FILENAME; \
    rm $FILENAME; \
    chown root:root sslocal ssmanager ssserver ssurl; \
    mv sslocal ssmanager ssserver ssurl /usr/local/bin

CMD [ "ssserver" ]