<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require('../vendor/autoload.php');

include('../config/routes.php');

echo \App\Framework\Router::execute($_SERVER['REQUEST_URI']);