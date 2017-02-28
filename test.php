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

		// Encryption settings
        'encryption' => [
            'key' => 'Nv7QU2Zuj9CWjuxxB2Edt3LWML53IAsF',
            'cipher' => 'AES-256-CBC',
        ],

        // Logger settings
        'logger' => [
            'name' => 'eric-log',
            'path' => __DIR__ . '/logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
	],
];

$app = new Bow\App($settings);
$container = $app->getContainer();

$cache = $container->get('db');

$encryption = $container->get('encryption');

$test = "123";

echo $encryption->encrypt($test) , "\r\n";

echo $encryption->decrypt($encryption->encrypt($test)) , "\r\n";


$logger = $container->get('logger');
$logger->info("test");
var_dump($cache->table('users')->get());
