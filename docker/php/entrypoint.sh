#!/bin/bash

cd /home/$APP_NAME
if [ -e /home/$APP_NAME/composer.json ]; then
  composer install
fi

chown -R $APP_NAME: /home/$APP_NAME

echo "$APP_NAME prêt : http://$APP_NAME.localhost:$WEB_PORT"

php-fpm