<?php

/** Base routes */
$router->get('/', 'DefaultController@homeAction', 'home');
$router->get('/article/{id}', 'DefaultController@testAction', 'test.index');
$router->post('/article/{id}', 'DefaultController@storeAction', 'test.store');

/** Security routes */
$router->get('/login', 'SecurityController@loginAction', 'security.login');
$router->post('/login', 'SecurityController@loginCheckAction', 'security.loginCheck');
$router->get('/register', 'SecurityController@registerAction', 'security.register');
$router->post('/register', 'SecurityController@storeAction', 'security.store');
$router->get('/logout', 'SecurityController@logoutAction', 'security.logout');