FROM systemhaus/php:7.4
WORKDIR /var/www/html
EXPOSE 8080
ENTRYPOINT ["php", "-d", "xdebug.remote_enable=1", "-d", "xdebug.remote_host=172.16.107.1", "-d", "xdebug.remote_connect_back=Off", "-S", "0.0.0.0:8080", "-t", "public", "public/index.php"]
