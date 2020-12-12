FROM alpine

ENV FRP_VERSION="0.34.3"
ENV FRP_DIR_NAME="frp_${FRP_VERSION}_linux_amd64"
ENV FRP_FILENAME="${FRP_DIR_NAME}.tar.gz"
ENV FRP_URL="https://github.com/fatedier/frp/releases/download/v${FRP_VERSION}/${FRP_FILENAME}"

RUN set -eux; \
	\	
	apk add --no-cache --virtual .persistent-deps \
		curl; \
	cd /root; \
	curl -fsSL -o "${FRP_FILENAME}" "${FRP_URL}"; \
	tar xf "${FRP_FILENAME}"; \
	rm "${FRP_FILENAME}"; \
	\
	chown root:root -R ${FRP_DIR_NAME}; \
	mv ${FRP_DIR_NAME} /etc/frp; \
	ln -s /etc/frp/frps /etc/frp/frpc /usr/local/bin

CMD [ "frps" ]