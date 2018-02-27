<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

use App\Controller\Controller;

require('../vendor/autoload.php');

$controller = new Controller();

$controller->indexAction();