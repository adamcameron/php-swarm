<?php

use App\Kernel;
use App\Service\EnvironmentService;

require_once dirname(__DIR__) . '/vendor/autoload_runtime.php';

EnvironmentService::load();

return function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
