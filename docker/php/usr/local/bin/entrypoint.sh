#!/bin/bash

rm -rf vendor
composer install
exec php-fpm
