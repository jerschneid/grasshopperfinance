<?php

require  __DIR__ . '/wp-config.local.php';

require  __DIR__ . '/wp-config.load.php';

return
[
    'paths' => [
        'migrations' => '%%PHINX_CONFIG_DIR%%/db/migrations',
        'seeds' => '%%PHINX_CONFIG_DIR%%/db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_database' => DB_NAME,
        'local' => [
            'adapter' => 'mysql',
            'host' => DB_HOST,
            'name' => DB_NAME,
            'user' => DB_USER,
            'pass' => DB_PASSWORD,
            'port' => '3306',
            'charset' => 'utf8',
        ],
        'production' => [
            'adapter' => 'mysql',
            'host' => PROD_DB_HOST,
            'name' => PROD_DB_NAME,
            'user' => PROD_DB_USER,
            'pass' => PROD_DB_PASSWORD,
            'port' => '3306',
            'charset' => 'utf8',
        ]
        /*,
        'testing' => [
            'adapter' => 'mysql',
            'host' => 'localhost',
            'name' => 'testing_db',
            'user' => 'root',
            'pass' => '',
            'port' => '3306',
            'charset' => 'utf8',
        ]*/
    ],
    'version_order' => 'creation'
];