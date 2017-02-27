<?php
require __DIR__ . '/vendor/autoload.php';

$app = new Bow\App($settings);
$container = $app->getContainer();

$cache = $container->get('cache');
