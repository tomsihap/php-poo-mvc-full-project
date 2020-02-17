<?php

use App\Service\ServiceContainer;

$configuration = [
    'db' => [
        'dsn'      => 'mysql:dbname=hblocatcars;host=localhost;port=8889;charset=utf8',
        'username' => 'root',
        'password' => 'root',
    ],
    'env' => [
        'base_path' => 'http://localhost:8888/mvc-correction',
        'site_name' => 'HB LocatCars'
    ]
];

require_once __DIR__ . '/../vendor/autoload.php';

$container = new ServiceContainer($configuration);

require_once __DIR__ . '/routes.php';