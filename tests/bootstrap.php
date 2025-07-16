<?php

use App\Service\EnvironmentService;

$app_dir = dirname(__DIR__);
require $app_dir . '/vendor/autoload.php';

EnvironmentService::load();
