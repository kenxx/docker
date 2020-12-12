FROM debian:buster-slim

ENV RRSHARE_URL="http://appdown.rrys.tv/rrshareweb_linux_2.20.tar.gz"

RUN set -eux; \
  \
  apt-get update; \
  apt-get install -y --no-install-recommends curl; \
  rm -rf /var/lib/apt/lists/*; \
  \
  cd /root; \
  curl -fsSL -o rrshare.tar.gz "$RRSHARE_URL"; \
  tar xf rrshare.tar.gz; \
  chown root:root -R rrshareweb; \
  rm rrshare.tar.gz; \
  mv rrshareweb /etc; \
  ln -s /etc/rrshareweb/rrshareweb /usr/local/bin

CMD [ "rrshareweb" ]