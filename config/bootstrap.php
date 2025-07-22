<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/env.php';

use App\Core\App;

App::run();

use App\Core\Router;
$routes = require_once __DIR__ . '/../route/route.web.php';
Router::resolve($routes);