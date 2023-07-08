FROM php:8.2-cli
ARG UID
ARG GID
ENV UID $UID
ENV GID $GID
RUN apt-get update && apt-get install --no-install-recommends -y \
        wget \
        vim \
        git \
        unzip \
        libzip-dev \
        coreutils \
        make \
        curl \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        zlib1g-dev \
        libicu-dev \
        g++ \
        unixodbc-dev \
        libxml2-dev \
        libaio-dev \
        libmemcached-dev \
        freetds-dev \
        libssl-dev \
        wkhtmltopdf \
        openssl
RUN echo "$(curl -sS https://composer.github.io/installer.sig) -" > composer-setup.php.sig \
        && curl -sS https://getcomposer.org/installer | tee composer-setup.php | sha384sum -c composer-setup.php.sig \
        && php composer-setup.php && rm composer-setup.php* \
        && chmod +x composer.phar && mv composer.phar /usr/bin/composer
RUN docker-php-ext-install \
            iconv \
            intl \
            gd \
            mysqli \
            pdo_mysql \
            sockets \
            zip

# dependencies for wkhtmltoimage
RUN apt-get install --no-install-recommends -y libxrender1 fontconfig libxext6


RUN echo ${GID}
RUN groupadd -o -g ${GID} appuser
RUN useradd -r -u ${UID} -g appuser appuser
USER appuser

WORKDIR /var/www/ccat-php
ENTRYPOINT ["php", "-S", "0.0.0.0:8081", "-t", "src"]
EXPOSE 8081
