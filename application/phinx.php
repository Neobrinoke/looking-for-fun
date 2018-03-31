<?php

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