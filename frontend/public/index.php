<?php
setlocale(LC_ALL, 'es_ES');
ini_set('date.timezone', 'America/Bogota');
const APP_CHARSET = 'UTF-8';

error_reporting(E_ALL ^ E_STRICT);

//ini_set('display_errors', 'Off'); // SERVIDOR: 'Off'
ini_set('display_errors', 'On'); // LOCAL: 'On'

//const PRODUCTION = true; // SERVIDOR = true
const PRODUCTION = false; // LOCAL = false

//const APP_ROOT_PRIVATE = '/home/u113041793/domains/colegiomixtosantarosa.com/_schoolnext_santarosa_private/'; // SERVIDOR SANTA ROSA
//const APP_ROOT_PRIVATE = '/home/windsor1/schoolnext_private/'; // SERVIDOR WINDSOR

//const APP_PATH         = APP_ROOT_PRIVATE.'frontend/app/'; // SERVIDOR
define('APP_PATH', dirname(__DIR__).'/app/');  // LOCAL

// const CORE_PATH        = APP_ROOT_PRIVATE.'core1.2/';  // SERVIDOR
define('CORE_PATH', dirname(dirname(APP_PATH)).'/core1.2/');  // LOCAL

//const PUBLIC_PATH = 'https://schoolnext.colegiomixtosantarosa.com/'; // SERVIDOR SANTA ROSA
//const PUBLIC_PATH = 'https://schoolnext.windsorschool.edu.co/'; // SERVIDOR WINDSOR
define('PUBLIC_PATH', substr($_SERVER['SCRIPT_NAME'], 0, -9)); // - index.php string[9]  LOCAL

//$url = $_SERVER['PATH_INFO'] ?? '/';  // SERVIDOR SANTA ROSA
//$url = $_SERVER['ORIG_PATH_INFO'] ?? '/'; // SERVIDOR WINDSOR
$url = $_SERVER['PATH_INFO'] ?? '/';  // LOCAL

require APP_PATH . 'libs/bootstrap.php'; //bootstrap de app
//require CORE_PATH.'kumbia/bootstrap.php'; //bootstrap del core (POR DEFAULT)