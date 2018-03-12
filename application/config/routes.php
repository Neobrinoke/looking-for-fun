<?php

/** Base routes */
$router->get('/', 'DefaultController@homeAction', 'home');

$router->middlewareGroup('CheckLogin', function ($middleware) use ($router) {
	$router->get('/article/{id}', 'DefaultController@testAction', 'test.index', $middleware);
	$router->post('/articles/{id}', 'DefaultController@storeAction', 'test.store', $middleware);
});

/** Security routes */
$router->get('/login', 'SecurityController@loginAction', 'security.login');
$router->post('/login', 'SecurityController@loginCheckAction', 'security.loginCheck');
$router->get('/register', 'SecurityController@registerAction', 'security.register');
$router->post('/register', 'SecurityController@storeAction', 'security.store');
$router->get('/logout', 'SecurityController@logoutAction', 'security.logout');