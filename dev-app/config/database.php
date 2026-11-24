<?php

$connection = [
    'driver' => 'pgsql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '5432'),
    'database' => env('DB_DATABASE', 'whodoku'),
    'username' => env('DB_USERNAME', 'whodoku'),
    'password' => env('DB_PASSWORD', ''),
    'charset' => 'utf8',
    'prefix' => '',
    'prefix_indexes' => true,
    'sslmode' => 'prefer',
];

return [
    'default' => 'pgsql',
    'connections' => [
        'pgsql' => [...$connection, 'search_path' => 'public'],
        'whodoku' => [...$connection, 'search_path' => 'whodoku'],
    ],
    'migrations' => ['table' => 'migrations', 'update_date_on_publish' => true],
];
