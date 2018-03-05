<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

// Session start
session_start();

// Autoloading
require('../vendor/autoload.php');

// Application start
$app = new \App\Framework\App();

// Routing
$app->router->get('/', 'DefaultController@homeAction', 'home');
$app->router->get('/article/{id}', 'DefaultController@testAction', 'test');

// Response
$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());

// Send response on the browser
\App\Framework\App::send($response);