<?php
/**
 * KumbiaPHP Web Framework
 * Parámetros de configuracion de la aplicacion
 */
return [
    'application' => [
        'production' => false,
        'database' => 'development',
        'dbdate' => 'YYYY-MM-DD',
        'debug' => 'On',
        'log_exceptions' => 'On', //log_exceptions: muestra las excepciones en pantalla (On/off)
        //'cache_template' => 'On', //cache_template: descomentar para habilitar cache de template
        'cache_driver' => 'file', //driver para la cache (file, sqlite, memsqlite)
        'metadata_lifetime' => '+1 year', // tiempo de vida de la metadata en cache
        'namespace_auth' => 'default',  // espacio de nombres por defecto para Auth
        'breadcrumb' => true, // activa breadcrumb
        'routes' => '1',  // descomentar para activar routes en routes.php
    ],
];
