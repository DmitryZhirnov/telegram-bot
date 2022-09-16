<?php

use Illuminate\Database\Capsule\Manager as Capsule;

require __DIR__ . '/' . '../init/init.php';

$connection = Capsule::connection();

return [
    'paths' => [
        'migrations' => [
            __DIR__ . '/' . '../db/migrations/'
        ],
        'seeds' => [
            __DIR__ . '/' . '../db/seeds/'
        ]
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_enviroment' => 'current',
        'current' => [
            'name' => $connection->getDatabaseName(),
            'connection' => $connection->getPdo()
        ]
    ]
];