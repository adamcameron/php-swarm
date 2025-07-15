<?php
use Symfony\Component\Dotenv\Dotenv;

$dotEnv = new Dotenv();

$dotEnv->loadEnv('/tmp/.env.mariadb');
$dotEnv->loadEnv('/run/secrets/app_secrets');
