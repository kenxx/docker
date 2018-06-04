FROM alpine

RUN mkdir /jbls

WORKDIR /jbls

RUN apk add --no-cache --virtual .persistent-deps \
		curl

RUN set -xe; \
	baseDir="https://github.com/kenxx/docker/releases/download/latest/IntelliJIDEALicenseServer_linux_"; \
	downloadType="386"; \
	\
	if [ $(getconf WORD_BIT) = '32' ] && [ $(getconf LONG_BIT) = '64' ] ; then \
	        downloadType="amd64"; \
	fi;\
	\
	curl -s -L -e '; auto' -o jbls "${baseDir}${downloadType}"; \
	if [[ -f jbls ]] ; then \
		chmod +x ./jbls; \
	fi

EXPOSE 1027

ENTRYPOINT ["/jbls/jbls"]

