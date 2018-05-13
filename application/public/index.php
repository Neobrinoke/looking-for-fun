<?php

//@todo retirer ça plus tard

error_reporting(E_ALL);
ini_set("display_errors", 1);

// Autoload
require('../vendor/autoload.php');

// Routes
require('../config/routes.php');

// Application start
$app = new \App\Framework\App();

// Response
$response = $app->run(\App\Framework\Http\Request::fromGlobals());

// Send response on the browser
$response->send();


$gameGroupsAll = \App\Model\GameGroup::all();

$gameGroupsFiltered = $gameGroupsAll->filter(function (\App\Model\GameGroup $gameGroup) {
	return $gameGroup->getOwnerId() === 1;
});

var_dump($gameGroupsFiltered);