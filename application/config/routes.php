<?php

use App\Framework\Router\Router;

/** Base Routes */
Router::get('/', 'DefaultController@homeAction', 'home');

/** GameGroups Routes */
Router::get('/groups', 'GameGroupController@indexAction', 'gameGroup.index');
Router::get('/group/create', 'GameGroupController@createAction', 'gameGroup.create')->middleware('Auth');
Router::post('/group/create', 'GameGroupController@storeAction', 'gameGroup.store')->middleware('Auth');
Router::get('/group/{gameGroup}', 'GameGroupController@showAction', 'gameGroup.show')->middleware('Auth');
Router::get('/group/edit/{gameGroup}', 'GameGroupController@editAction', 'gameGroup.edit')->middleware('Auth');
Router::post('/group/edit/{gameGroup}', 'GameGroupController@updateAction', 'gameGroup.update')->middleware('Auth');
Router::get('/group/delete/{gameGroup}', 'GameGroupController@deleteAction', 'gameGroup.delete')->middleware('Auth');
Router::get('/group/join/{gameGroup}', 'GameGroupController@joinAction', 'gameGroup.join')->middleware('Auth');
Router::get('/group/expel/{gameGroup}/{userId}', 'GameGroupController@expelAction', 'gameGroup.expel')->middleware('Auth');

/** Security Routes */
Router::get('/login', 'SecurityController@loginAction', 'security.login')->middleware('Guest');
Router::post('/login', 'SecurityController@loginCheckAction', 'security.loginCheck')->middleware('Guest');
Router::get('/register', 'SecurityController@registerAction', 'security.register')->middleware('Guest');
Router::post('/register', 'SecurityController@storeAction', 'security.store')->middleware('Guest');
Router::get('/logout', 'SecurityController@logoutAction', 'security.logout')->middleware('Auth');

/** Tests Routes */
Router::get('/test', 'DefaultController@testAction', 'test.test');