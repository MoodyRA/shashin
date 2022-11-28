#!/bin/bash

cd /home/shashin
if [ -e /home/shashin/composer.json ]; then
  composer install
fi

chown -R $USER_NAME: /home/shashin

echo "shashin prêt : http://shashin.localhost:$WEB_PORT"

php-fpm