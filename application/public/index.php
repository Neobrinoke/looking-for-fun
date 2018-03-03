<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

use App\Controller\Controller;

require('../vendor/autoload.php');

//class Router
//{
//    /** @var array */
//    private $routes;
//
//    public function addRoute($url, $controller)
//    {
//
//    }
//}
//
//class RouterObject
//{
//
//}
//
//preg_match('`.*/groupe/(.*)/add/(.*)/`isU', '/dsqdqsdqsd/groupe/654/add/654654/', $match);
//var_dump($match);

$controller = new Controller();

$controller->indexAction();