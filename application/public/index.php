<?php

//@todo retirer ça plus tard
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Autoload
require('../vendor/autoload.php');

// Routes
require('../config/routes.php');

// Application start
$app = new \App\Framework\App();

// Response
$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());

// Send response on the browser
\App\Framework\App::send($response);