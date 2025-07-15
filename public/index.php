<?php

use App\Kernel;

$app_dir = dirname(__DIR__);
require_once $app_dir . '/vendor/autoload_runtime.php';
require_once $app_dir . '/load_app_secrets.php';

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
