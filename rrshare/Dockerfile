FROM debian:buster

ENV RRSHARE_URL="http://appdown.rrys.tv/rrshareweb_linux_2.20.tar.gz"

RUN set -eux; \
  \
  savedAptMark="$(apt-mark showmanual)"; \
  apt-get update; \
  apt-get install -y --no-install-recommends curl; \
  rm -rf /var/lib/apt/lists/*; \
  \
  cd /root; \
  \
  curl -fsSL -o rrshare.tar.gz "$RRSHARE_URL"; \
  tar xf rrshare.tar.gz; \
  chown root:root -R rrshareweb; \
  mv rrshareweb /etc; \
  rm rrshare.tar.gz; \
  \
  apt-mark auto '.*' > /dev/null; \
  apt-mark manual $savedAptMark > /dev/null; \
  apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false

CMD [ "/etc/rrshareweb/rrshareweb" ]