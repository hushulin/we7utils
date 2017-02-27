<?php
require __DIR__ . '/vendor/autoload.php';

$settings = [
	'settings' => [
		// Database settings
		'db' => [
		// 'write' => [
		// 'host' => ['192.168.1.5','192.168.1.5','192.168.1.5'],
		// ],
		// 'read' => [
		// 'host' => [
		// '192.168.1.5',
		// '192.168.1.5',
		// '192.168.1.5',
		// '192.168.1.5',
		// '192.168.1.5',
		// '192.168.1.5',
		// ],
		// ],
		'driver' => 'mysql',
		'host' => '114.115.212.17',
		'database' => 'we7',
		'username' => 'root',
		'password' => 'hushulin', //
		'charset' => 'utf8',
		'collation' => 'utf8_general_ci',
		'prefix' => 'ims_',
		],
	],
];

$app = new Bow\App($settings);
$container = $app->getContainer();

$cache = $container->get('db');

var_dump($cache->table('users')->get());
