<?php

use App\Framework\Router\Router;

Router::get('/', 'home', 'DefaultController@homeAction');
Router::get('/article/{id}', 'test', 'DefaultController@testAction');