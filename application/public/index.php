<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);


// Session start
session_start();

// Autoloading
require('../vendor/autoload.php');


// Application start
$app = new \App\Framework\App();
echo $app->run($_SERVER['REQUEST_URI']);