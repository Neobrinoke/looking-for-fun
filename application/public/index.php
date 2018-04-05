<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

// Autoload
require('../vendor/autoload.php');

$container = (new \DI\ContainerBuilder())->build();

// Routes config
$router = $container->get(\App\Framework\Router\Router::class);
require('../config/routes.php');

// Application start
$app = new \App\Framework\App($container);

// Response
$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());

// Send response on the browser
\App\Framework\App::send($response);