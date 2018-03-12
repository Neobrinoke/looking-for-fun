<?php

/** Base Routes */
$router->get('/', 'DefaultController@homeAction', 'home');

$router->middlewareGroup('CheckLogin', function ($middleware) use ($router) {
	$router->get('/article/{id}', 'DefaultController@testAction', 'test.index', $middleware);
	$router->post('/articles/{id}', 'DefaultController@storeAction', 'test.store', $middleware);
});

/** GameGroups Routes */
$router->get('/groups', 'GameGroupController@indexAction', 'gameGroup.index');
$router->get('/group/create', 'GameGroupController@createAction', 'gameGroup.create');
$router->post('/group/create', 'GameGroupController@storeAction', 'gameGroup.store');

/** Security Routes */
$router->get('/login', 'SecurityController@loginAction', 'security.login');
$router->post('/login', 'SecurityController@loginCheckAction', 'security.loginCheck');
$router->get('/register', 'SecurityController@registerAction', 'security.register');
$router->post('/register', 'SecurityController@storeAction', 'security.store');
$router->get('/logout', 'SecurityController@logoutAction', 'security.logout');