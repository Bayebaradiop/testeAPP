<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/env.php';

use App\Core\App;
use App\Core\Router;

App::run();
$routes = require_once __DIR__ . '/route/route.web.php';
Router::resolve($routes);