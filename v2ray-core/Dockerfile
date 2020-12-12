FROM alpine

ENV V2RAY_URL="https://github.com/v2fly/v2ray-core/releases/download/v4.33.0/v2ray-linux-64.zip"

RUN set -ex; \
    apk add --no-cache --virtual .persistent-deps \
		curl; \
    v2ray_prefix="/etc/v2ray"; \
    mkdir ${v2ray_prefix}; \
    cd ${v2ray_prefix}; \
    curl -fsSL -o "v2ray-linux-64.zip" "$V2RAY_URL"; \
    unzip "v2ray-linux-64.zip"; \
    rm "v2ray-linux-64.zip"; \
    ln -s ${v2ray_prefix}/v2ray ${v2ray_prefix}/v2ctl /usr/local/bin

CMD [ "v2ray" ]