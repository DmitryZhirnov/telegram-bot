<?php

use Illuminate\Database\Capsule\Manager as Capsule;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$capsule = new Capsule();
$credentials = [
    'driver'    => 'mysql',
    'host'      => env('DB_HOST'),
    'port'      => env('DB_PORT'),
    // optional
    'user'      => env('DB_USER'),
    'username'  => env('DB_USER'),
    'password'  => env('DB_PASSWORD'),
    'database'  => env('DB_NAME'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
];
$capsule->addConnection($credentials);
//Make this Capsule instance available globally.
$capsule->setAsGlobal();
// Setup the Eloquent ORM.
$capsule->bootEloquent();
return $capsule;