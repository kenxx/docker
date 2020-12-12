FROM alpine

ENV SS_RUST_VERION="1.8.23"
ENV SS_RUST_FILENAME="shadowsocks-v${SS_RUST_VERION}.x86_64-unknown-linux-musl.tar.xz"
ENV SS_RUST_URL="https://github.com/shadowsocks/shadowsocks-rust/releases/download/v${SS_RUST_VERION}/${SS_RUST_FILENAME}"

RUN set -eux; \
    apk add --no-cache --virtual .persistent-deps \
		curl; \
    \
    cd /root; \
    curl -fsSL -o $SS_RUST_FILENAME "$SS_RUST_URL"; \
    tar xf $SS_RUST_FILENAME; \
    rm $SS_RUST_FILENAME; \
    chown root:root sslocal ssmanager ssserver ssurl; \
    mv sslocal ssmanager ssserver ssurl /usr/local/bin

CMD [ "ssserver" ]