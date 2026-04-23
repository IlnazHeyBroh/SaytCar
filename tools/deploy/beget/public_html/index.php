<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

$projectRoot = dirname(__DIR__);

if (file_exists($maintenance = $projectRoot . '/storage/framework/maintenance.php')) {
    require $maintenance;
}

require $projectRoot . '/vendor/autoload.php';

$app = require_once $projectRoot . '/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
