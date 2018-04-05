<?php

use function DI\env;

return [
	'migration_base_class' => 'App\Framework\Database\Migration',
	'seed_base_class' => 'App\Framework\Database\Seeder',
	'paths' => [
		'migrations' => __DIR__ . '/database/migrations',
		'seeds' => __DIR__ . '/database/seeds'
	],
	'templates' => [
		'file' => __DIR__ . '/src/Framework/Database/Template/migration_template_file.txt',
	],
	'environments' => [
		'default_database' => 'development',
		'development' => [
			'adapter' => 'mysql',
			'host' => env('DB_HOST'),
			'name' => env('DB_DATABASE'),
			'user' => env('DB_USERNAME'),
			'pass' => env('DB_PASSWORD'),
			'port' => env('DB_PORT')
		],
		'test' => [
			'adapter' => 'sqlite',
			'connection' => null
		]
	]
];