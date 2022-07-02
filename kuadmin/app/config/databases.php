<?php
/**
 * KumbiaPHP Web Framework
 * Parámetros de conexión a la base de datos
 */
return [
    'default' => [
        'dsn'      => 'mysql:host=127.0.0.1;dbname=dwsjrnmy_windsor;charset=utf8',
        'username' => 'dwsjrnmy_windsor',
        'password' => 'p#1pp#P0qGg;',
        'params'   => [
            //PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', //UTF8 en PHP < 5.3.6
            \PDO::ATTR_PERSISTENT => \true, //conexión persistente
            \PDO::ATTR_ERRMODE    => \PDO::ERRMODE_EXCEPTION
        ]
    ]
];

/**
 * Ejemplo de SQLite
 */
/*
return ['default' => [
        'dsn' => 'sqlite:'.APP_PATH.'temp/sqlite/ku_admin.db',
        'pdo' => 'On',
    ]    
];
*/
