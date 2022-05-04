FROM php:7-cli
MAINTAINER Eugene Terentev <eugene@terentev.net>

RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get --yes install \
        git \
        openssl \
        curl \
        wget \
        libicu-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng-dev \
        libicu-dev 

RUN apt-get update && apt-get install -y libmcrypt-dev \
    && pecl install mcrypt-1.0.4 \
    && docker-php-ext-enable mcrypt \

#     && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install gd

# RUN docker-php-ext-install zip mcrypt intl mbstring pdo_mysql \
#     && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
#     && docker-php-ext-install gd

RUN curl -sL https://deb.nodesource.com/setup_lts.x | bash -

RUN DEBIAN_FRONTEND=noninteractive apt-get --yes install \
        nodejs \
        build-essential \
        default-jre

RUN curl -sL https://www.npmjs.org/install.sh | bash -

RUN apt-get autoremove -y \
        && rm -r /var/lib/apt/lists/*

RUN npm install -g uglifyjs yuicompressor

# Install composer && global asset plugin
ENV COMPOSER_HOME /root/.composer
ENV PATH /root/.composer/vendor/bin:$PATH

RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer \
&& composer global require --no-progress "fxp/composer-asset-plugin:~1.2" \
&& apk del tzdata \
&& rm -rf /var/cache/apk/*

# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
#     /usr/local/bin/composer global require "fxp/composer-asset-plugin"

COPY . /app
RUN chown www-data:www-data -R /app
USER www-data