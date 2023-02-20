<?php
/**
 * KumbiaPHP Web Framework
 * Parámetros de configuracion de la aplicacion
 *  @example 
 */

$year = date('Y');

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
        'breadcrumb' => false, // activa breadcrumb
        'routes' => '1',  // descomentar para activar routes en routes.php
    ],
    'academic' => [
      'annio_inicial'  => 2006,
      'annio_actual'   => 2023,
      'periodo_actual' => 1,
    ],
    'construxzion' => [
      'name'      => 'ConstruxZion Soft CO',
      'ceo'       => 'Odair De La Hoz Rojas',
      'email'     => 'odairdelahoz@gmail.com',
      'twitter'   => 'https://twitter.com/construxzion',
      'copy'      => "Copyright © $year",
      'copy_text' => "Todos los Derechos Reservados",
      'telefono'  => '+573017153066',
      'whatsapp'  => '+573017153066',
      'email'     => 'admin@windsorschool.edu.co',
    ],
    'institution' => [
      'nombre'          => 'Windsor School',
      'razon_social'    => 'Windsor Group SAS',
      'id_name'         => 'windsor',
      'cod_dane'        => '320001068151',
      'resolucion'      => '293, Nov 4 de 2011',

      'slogan'          => 'Brilliant minds for a challenging world',
      'campania'        => 'No esperemos que el mundo cambie. Primero hagámoslo nosotros.',
      'logo'            => 'ws_logo.png',
      'logo_resolucion' => 'ws_logo.png',
      
      'direccion'       => 'Calle 9A #5-22 Barrio Novalito',
      'telefono_fijo'   => '605 589 7997',
      'telefono_movil'  => '(+57) 317 370 4197',
      'email'           => 'windsorschoolvalledupar@gmail.com',
      'dominio'         => 'windsorschool.edu.co',
      
      'rector'          => 'Miriam Casadiego Ríos',
      'rector_cc'       => '57401865',
      
      'rep_legal'       => 'Yani Calderón Sarmiento',
      'rep_legal_cc'    => '',
      
      'secretaria'      => 'Yuleinis Manjarres Gil',
      'secretaria_cc'   => '1065579951',
      
      'contador'        => 'Mary Monachello',
      'contador_cc'     => '',
      
    ],
];
