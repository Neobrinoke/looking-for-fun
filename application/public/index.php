<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

// Session start
session_start();

// Autoloading
require('../vendor/autoload.php');

// Application start
$app = new \App\Framework\App();

/**
 * Routes
 */
// Base routes
$app->router->get('/', 'DefaultController@homeAction', 'home');
$app->router->get('/article/{id}', 'DefaultController@testAction', 'test.index');
$app->router->post('/article/{id}', 'DefaultController@storeAction', 'test.store');
// Security
$app->router->get('/login', 'SecurityController@loginAction', 'security.login');
$app->router->post('/login', 'SecurityController@loginCheckAction', 'security.loginCheck');
$app->router->get('/register', 'SecurityController@registerAction', 'security.register');
$app->router->post('/register', 'SecurityController@storeAction', 'security.store');

// Response
$response = $app->run(\GuzzleHttp\Psr7\ServerRequest::fromGlobals());

// Send response on the browser
\App\Framework\App::send($response);