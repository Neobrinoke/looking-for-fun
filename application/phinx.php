<?php

return [
	'paths' => [
		'migrations' => __DIR__ . '/database/migrations',
		'seeds' => __DIR__ . '/database/seeds'
	],
	'environments' => [
		'default_database' => 'development',
		'development' => [
			'adapter' => 'mysql',
			'host' => DB_HOST,
			'name' => DB_DATABASE,
			'user' => DB_USERNAME,
			'pass' => DB_PASSWORD,
			'port' => DB_PORT
		],
		'test' => [
			'adapter' => 'sqlite',
			'connection' => null
		]
	]
];