<?php

/** Base Routes */
$router->get('/', 'DefaultController@homeAction', 'home');

/** GameGroups Routes */
$router->get('/groups', 'GameGroupController@indexAction', 'gameGroup.index');
$router->get('/group/create', 'GameGroupController@createAction', 'gameGroup.create')->middleware('Auth');
$router->post('/group/create', 'GameGroupController@storeAction', 'gameGroup.store')->middleware('Auth');
$router->get('/group/{gameGroup}', 'GameGroupController@showAction', 'gameGroup.show')->middleware('Auth');
$router->get('/group/edit/{gameGroup}', 'GameGroupController@editAction', 'gameGroup.edit')->middleware('Auth');
$router->post('/group/edit/{gameGroup}', 'GameGroupController@updateAction', 'gameGroup.update')->middleware('Auth');
$router->get('/group/delete/{gameGroup}', 'GameGroupController@deleteAction', 'gameGroup.delete')->middleware('Auth');

/** Security Routes */
$router->get('/login', 'SecurityController@loginAction', 'security.login')->middleware('Guest');
$router->post('/login', 'SecurityController@loginCheckAction', 'security.loginCheck')->middleware('Guest');
$router->get('/register', 'SecurityController@registerAction', 'security.register')->middleware('Guest');
$router->post('/register', 'SecurityController@storeAction', 'security.store')->middleware('Guest');
$router->get('/logout', 'SecurityController@logoutAction', 'security.logout')->middleware('Auth');

/** Tests Routes */
$router->get('/test', 'DefaultController@testAction', 'test.test');