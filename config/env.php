<?php

$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

define('URL', $_ENV['URL']);
define('IMG_DIR', $_ENV['IMG_DIR']);


define("DB_USERNAME", $_ENV["DB_USERNAME"]); 
define("DB_PASSWORD", $_ENV["DB_PASSWORD"]);
define("TWILIO_SID", $_ENV["TWILIO_SID"]);
define("TWILIO_TOKEN", $_ENV["TWILIO_TOKEN"]);
define("TWILIO_FROM", $_ENV["TWILIO_FROM"]);
define("DSN", $_ENV["dsn"]);