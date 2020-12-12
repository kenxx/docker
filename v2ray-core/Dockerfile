FROM alpine

ENV V2RAY_VERSION="4.33.0"
ENV V2RAY_FILENAME="v2ray-linux-64.zip"
ENV V2RAY_URL="https://github.com/v2fly/v2ray-core/releases/download/v${V2RAY_VERSION}/${V2RAY_FILENAME}"

RUN set -eux; \
    apk add --no-cache --virtual .persistent-deps \
		curl; \
    \
    mkdir /etc/v2ray; \
    cd /etc/v2ray; \
    curl -fsSL -o "${V2RAY_FILENAME}" "$V2RAY_URL"; \
    unzip "${V2RAY_FILENAME}"; \
    rm "${V2RAY_FILENAME}"; \
    \
    ln -s /etc/v2ray/v2ray /etc/v2ray/v2ctl /usr/local/bin

CMD [ "v2ray" ]