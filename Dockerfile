FROM php:7.1-apache as build

RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libpng-dev \
        libwebp-dev \
        libjpeg62-turbo-dev \
        libpng-dev libxpm-dev \
        libfreetype6-dev \
        npm \
	&& docker-php-ext-configure gd \
	    --with-gd \
	    --with-webp-dir \
	    --with-jpeg-dir \
	    --with-png-dir \
	    --with-zlib-dir \
	    --with-xpm-dir \
	    --with-freetype-dir \
	    --enable-gd-native-ttf --with-freetype --with-jpeg \
	&& docker-php-ext-install -j$(nproc) gd mysqli pdo pdo_mysql bcmath \
        && docker-php-ext-enable mysqli
RUN apt-get update && apt-get install curl --no-install-recommends dialog openssh-server -y 
RUN echo "root:Docker!" | chpasswd # buildkit
COPY sshd_config /etc/ssh/sshd_config
COPY apache-with-ssh.sh /app/apache-with-ssh.sh
RUN  sed -i 's/\r//' /app/apache-with-ssh.sh


RUN a2enmod rewrite
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/conf.d/dev.ini
RUN echo "PassEnv DB_HOST DB_USERNAME DB_DATABASE DB_PASSWORD APP_ENV APP_DEBUG APP_KEY NOCAPTCHA_SECRET NOCAPTCHA_SITEKEY AWS_KEY AWS_SECRET AWS_BUCKET EMAIL_TO BYPASS_CAPTCHA" >/etc/apache2/conf-available/lav-env.conf
WORKDIR /etc/apache2/conf-enabled
RUN ln -s ../conf-available/lav-env.conf lav-env.conf
RUN echo 'ServerName localhost;' >>/etc/apache2/apache2.conf

WORKDIR /src
COPY . .
COPY --from=composer:2.2 /usr/bin/composer /usr/bin/composer
RUN npm install -g gulp
RUN npm install
RUN groupadd -r user && useradd -r -g user user
RUN chown -R user: .
USER user
RUN composer install
RUN gulp --production
RUN cp -f .env.example .env
#RUN php artisan key:generate
USER root
RUN mv -f /src/* /var/www
RUN mv -f /src/.env /var/www
RUN rm -rf /var/www/html
RUN ln -s /var/www/public /var/www/html
RUN chown -R www-data: /var/www/*
EXPOSE 80 443 2222
ENTRYPOINT ["/app/apache-with-ssh.sh"]
