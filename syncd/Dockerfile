FROM alpine:latest

RUN mkdir /usr/local/syncd

COPY ./output /usr/local/syncd

RUN ln -s /usr/local/syncd/bin/syncd /usr/local/bin/syncd

WORKDIR /usr/local/syncd/bin

CMD [ "syncd", "-c", "/usr/local/syncd/etc/syncd.ini" ]

