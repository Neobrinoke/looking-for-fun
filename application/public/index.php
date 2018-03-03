<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require('../vendor/autoload.php');

session_start();

require('../config/routes.php');

$app = new \App\Framework\App();
echo $app->run($_SERVER['REQUEST_URI']);