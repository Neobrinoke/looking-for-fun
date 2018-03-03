<?php

use App\Framework\Router;

Router::get('/blog/(\w+)/(\w+)', 'Controller@indexAction', 'blog');