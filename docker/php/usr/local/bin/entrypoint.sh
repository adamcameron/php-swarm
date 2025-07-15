#!/bin/bash

export MARIADB_PASSWORD=$(cat /run/secrets/mariadb_password)
echo "MARIADB_PASSWORD=$MARIADB_PASSWORD" > /tmp/.env.mariadb

rm -rf vendor
composer install
exec php-fpm
