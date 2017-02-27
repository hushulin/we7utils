<?php
require __DIR__ . '/vendor/autoload.php';

$settings = [
	'settings' => [
		'host' => '127.0.0.1',
	],
];

$app = new Bow\App($settings);
$container = $app->getContainer();

$cache = $container->get('settings');

var_dump($cache);
