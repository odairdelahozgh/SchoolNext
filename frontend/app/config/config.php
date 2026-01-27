<?php
/**
 * KumbiaPHP Web Framework
 * Parámetros de configuracion de la aplicacion
 *  @example (int)Config::get(var: 'academic.periodo_actual');
 */

$year = date('Y');

$DoliK = new DoliConst();
define('INSTITUTION_KEY',   $DoliK->getValue('SCHOOLNEXTCORE_INSTITUTO_KEY' ?? ''));
define('INSTITUTION_NAME',  $DoliK->getValue('MAIN_INFO_SOCIETE_NOM' ?? ''));
define('INSTITUTION_MAIL', $DoliK->getValue('MAIN_INFO_SOCIETE_MAIL' ?? ''));
define('INSTITUTION_FRM_ADMISIONES', $DoliK->getValue('SCHOOLNEXTADMISIONES_FORMULARIO') ?? 'formsencillo');

define('ANNIO_INICIAL', (int)$DoliK->getValue('SCHOOLNEXTCORE_ANNIO_INICIAL'));
define('ANNIO_ACTUAL', (int)$DoliK->getValue('SCHOOLNEXTACADEMICO_ANNIO_ACTUAL'));
define('PERIODO_ACTUAL', (int)$DoliK->getValue('SCHOOLNEXTACADEMICO_PERIODO_ACTUAL'));
define('ANNIO_MATRICULA', (int)$DoliK->getValue('SCHOOLNEXTACADEMICO_MATRICULA_ANNIO'));
define('SHOW_NOTA_BOLETIN', (bool)$DoliK->getValue('SCHOOLNEXTACADEMICO_SHOW_NOTA_BOLETIN'));
define('SHOW_MATRICULA', (bool)$DoliK->getValue('SCHOOLNEXTACADEMICO_MATRICULA_ACTIVO'));

define('MAX_PERIODOS', (int)(new PeriodoD())::getNumPeriodos());

$PeriodoActual = (new PeriodoD())->get(PERIODO_ACTUAL);
define('PERIODO_INICIO', $PeriodoActual->fecha_inicio ?? '');
define('PERIODO_FIN', $PeriodoActual->fecha_fin ?? '');
define('PERIODO_INI_NOTAS', $PeriodoActual->f_ini_notas ?? '');
define('PERIODO_FIN_NOTAS', $PeriodoActual->f_fin_notas ?? '');
define('PERIODO_INI_LOGROS', $PeriodoActual->f_ini_logro ?? '');
define('PERIODO_FIN_LOGROS', $PeriodoActual->f_fin_logro ?? '');
define('PERIODO_OPENDAY', $PeriodoActual->f_open_day ?? '');
define('PERIODO_MES_REQ_BOLETIN', $PeriodoActual->mes_req_boletin ?? 4);

define('PERIODO_INI_SEGUIM', $PeriodoActual->f_ini_seguimientos ?? '');
define('PERIODO_FIN_SEGUIM', $PeriodoActual->f_fin_seguimientos ?? '');
define('PERIODO_INI_PREINF', $PeriodoActual->f_ini_preinformes ?? '');
define('PERIODO_FIN_PREINF', $PeriodoActual->f_fin_preinformes ?? '');
define('PERIODO_INI_PAPOYO', $PeriodoActual->f_ini_planes_apoyo ?? '');
define('PERIODO_FIN_PAPOYO', $PeriodoActual->f_fin_planes_apoyo ?? '');

define('PERIODO_SEGUIM_ABRIR',  $PeriodoActual->seguimientos_abrir ?? '');
define('PERIODO_SEGUIM_CERRAR', $PeriodoActual->seguimientos_cerrar ?? '');
define('PERIODO_PREINF_ABRIR',  $PeriodoActual->preinformes_abrir ?? '');
define('PERIODO_PREINF_CERRAR', $PeriodoActual->preinformes_cerrar ?? '');
define('PERIODO_BOLETIN_ABRIR',  $PeriodoActual->boletines_abrir ?? '');
define('PERIODO_BOLETIN_CERRAR', $PeriodoActual->boletines_cerrar ?? '');
define('PERIODO_PAPOYO_ABRIR',  $PeriodoActual->planes_apoyo_abrir ?? '');
define('PERIODO_PAPOYO_CERRAR', $PeriodoActual->planes_apoyo_cerrar ?? '');


return [
    'application' => [
        'production' => false,
        'database' => 'windsor',
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

    'calificaciones' => [
      'periodos_excep' => '1',
      'salones_excep'  => '11-A',
      'usuarios_excep' => '',
    ],

    // Esto se eliminará
    // La información saldrá de la API de ConstruxZionSoft
    'construxzion' => [
      'name'      => 'ConstruxZion Soft CO',
      'ceo'       => 'Odair De La Hoz Rojas',
      'website'   => 'https://construxzionsoft.com.co',
      'twitter'   => 'https://twitter.com/construxzion',
      'copy'      => "Copyright © $year",
      'copy_text' => "Todos los Derechos Reservados",
      'telefono'  => '+573017153066',
      'whatsapp'  => '+573017153066',
      'email'     => 'contacto@construxzionsoft.com.co',
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