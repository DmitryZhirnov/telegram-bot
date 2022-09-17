<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/init_db.php';


use Illuminate\Database\Capsule\Manager as Capsule;

$connection = Capsule::connection();

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
