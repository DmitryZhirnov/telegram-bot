<?php

require __DIR__ . '/../vendor/autoload.php';

// Instantiate PHP-DI ContainerBuilder
$containerBuilder = new \DI\ContainerBuilder();
// Set up settings
$settings = require __DIR__ . '/../app/settings.php';
$settings($containerBuilder);
// Set up dependencies
$dependencies = require __DIR__ . '/../app/dependencies.php';
$dependencies($containerBuilder);
$container = $containerBuilder->build();
$capsule = $container->get('db');
$connection = $capsule->getConnection();

return [
    'paths'        => [
        'migrations' => [
            __DIR__ . DIRECTORY_SEPARATOR . 'migrations',
        ],
        'seeds'      => [
            __DIR__ . DIRECTORY_SEPARATOR . 'seeds',
        ],
    ],
    'environments' => [
        'default_enviroment' => 'current',
        'current'            => [
            'name'       => $connection->getDatabaseName(),
            'connection' => $connection->getPdo(),
        ],
    ],
];
