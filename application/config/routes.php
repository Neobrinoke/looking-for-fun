<?php

use App\Framework\Router\Router;

Router::get('/', 'DefaultController@homeAction', 'home');
Router::get('/article/{id}', 'DefaultController@testAction', 'test');