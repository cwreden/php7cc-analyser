FROM php:7.1

LABEL maintainer="christian@wreden.eu"

WORKDIR "/opt"

COPY bin/ /usr/local/php7ccAnalyser/bin/
COPY vendor/ /usr/local/php7ccAnalyser/vendor/
COPY src/ /usr/local/php7ccAnalyser/src/

RUN chmod +x /usr/local/php7ccAnalyser/bin/php7ccAnalyser

RUN ln -s /usr/local/php7ccAnalyser/bin/php7ccAnalyser /usr/local/bin/php7ccAnalyser
