<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

// Session start
session_start();

// Autoloading
require('../vendor/autoload.php');

// Application start
$app = new \App\Framework\App();


$app->router->get('/', 'DefaultController@homeAction', 'home');
$app->router->get('/article/{id}', 'DefaultController@testAction', 'test');


$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());

\App\Framework\App::send($response);