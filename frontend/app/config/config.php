<?php
/**
 * KumbiaPHP Web Framework
 * Parámetros de configuracion de la aplicacion
 *  @example (int)Config::get(var: 'academic.periodo_actual');
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
        'modo_depuracion_admin' => 0,
    ],

    'theme' => [
      'admin'  => 'w3', //w3 bootstrap
      'users'  => 'w3',
    ],

    'academic' => [
      'annio_inicial'  => 2006,
      'annio_actual'   => 2024,
      'periodo_actual' => 4,
      'asignar_carga' => ['*'],
    ],

    'boletines' => [
      'imprimir_plan_apoyo' => false,
      'imprimir_nota'       => false,
    ],

    'calificaciones' => [
      'periodos_excep' => '1',
      'salones_excep'  => '11-A',
      'usuarios_excep' => '',
    ],

    'construxzion' => [
      'name'      => 'ConstruxZion Soft CO',
      'ceo'       => 'Odair De La Hoz Rojas',
      'twitter'   => 'https://twitter.com/construxzion',
      'copy'      => "Copyright © $year",
      'copy_text' => "Todos los Derechos Reservados",
      'telefono'  => '+573017153066',
      'whatsapp'  => '+573017153066',
      'email'     => 'contacto@construxzionsoft.com.co',
      'app_name'  => APP_NAME,
      'app_description'  => 'SchoolNext>> Es una Aplicación Web Moderna para la Gestión de Instituciones Educativas de Colombia',
    ],

    // esto se va a eliminar
    'institution' => [
      'nombre'  => 'Windsor School',
      'razon_social'  => 'Windsor Group SAS',
      'id_name' => 'windsor',
      'nit' => '900329420',
      'cod_dane'  => '320001068151',
      'resolucion'  => '293, Nov 4 de 2011',

      'slogan'  => 'Brilliant minds for a challenging world',
      'campania'  => 'No esperemos que el mundo cambie. Primero hagámoslo nosotros.',
      'logo'  => 'logo.png',
      'logo_resolucion' => 'logo.png',
      
      'ciudad' => 'Valledupar',
      'direccion' => 'Kilometro 2.5 via Rio Seco - Valledupar, Cesar',
      'telefono_fijo' => '(+601) 794-4484',
      'telefono_movil'  => '(+57) 317 370 4197',
      'email' => 'windsorschoolvalledupar@gmail.com',
      'dominio' => 'windsorschool.edu.co',
      'website' => 'https://www.windsorschool.edu.co',
      
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