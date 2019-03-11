<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'domain'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
        ],

        /**
         * 預設連線，我們將設計成只存放各應用程式的migration table
         * 使用具Schema變更權限的帳號及存放migration table的資料庫
         */
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('MIGRATE_HOST', '192.168.1.123'),
            'port' => env('MIGRATE_PORT', '3306'),
            'database' => env('MIGRATE_DATABASE', 'migrations'),
            'username' => env('MIGRATE_USERNAME', 'migration'),
            'password' => env('MIGRATE_PASSWORD', 'dw057RWR!'),
            'unix_socket' => env('MIGRATE_SOCKET', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        // 使用具Schema變更權限的帳號在應用資料庫執行遷移任務
        'migrations' => [
            'driver' => 'mysql',
            'host' => env('DM_HOST', '192.168.1.123'),
            'port' => env('DM_PORT', '3306'),
            'database' => env('DM_DATABASE', 'domain_manage'),
            'username' => env('MIGRATE_USERNAME', 'migration'),
            'password' => env('MIGRATE_PASSWORD', 'dw057RWR!'),
            'unix_socket' => env('DM_SOCKET', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],

        // Domain manager database connection
        'domain' => [
            'driver' => 'mysql',
            'host' => env('DM_HOST', '192.168.1.123'),
            'port' => env('DM_PORT', '3306'),
            'database' => env('DM_DATABASE', 'domain_manage'),
            'username' => env('DM_USERNAME', 'app'),
            'password' => env('DM_PASSWORD', 'vdBEkp9x!'),
            'unix_socket' => env('DM_SOCKET', ''),
            'charset' => 'utf8',
            'collation' => 'utf8_general_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'domain_manage',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
