<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/init_db.php';

use Illuminate\Database\Capsule\Manager as Capsule;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$connection = Capsule::connection();

return [
    'paths'        => [
        'migrations' => [
            __DIR__ . '/' . '../db/migrations/',
        ],
        'seeds'      => [
            __DIR__ . '/' . '../db/seeds/',
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
