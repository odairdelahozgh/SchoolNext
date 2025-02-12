<?php
setlocale(LC_ALL, 'es_ES');
ini_set('date.timezone', 'America/Bogota');
const APP_CHARSET = 'UTF-8';
error_reporting(E_ALL ^ E_STRICT);
ini_set('display_errors', 'Off'); // Off/On
const PRODUCTION = false; // servidor=true / local=false

//const APP_ROOT_PRIVATE = '/home/u113041793/domains/colegiomixtosantarosa.com/_schoolnext_santarosa_private/';
//const APP_ROOT_PRIVATE = '/home/tecnoro1/schoolnext_private/';

//const APP_PATH = APP_ROOT_PRIVATE.'frontend/app/'; // SERVIDOR
define('APP_PATH', dirname(__DIR__).'/app/');

// const CORE_PATH = APP_ROOT_PRIVATE.'core1.2/';  // SERVIDOR
define('CORE_PATH', dirname(dirname(APP_PATH)).'/core1.2/');

//const PUBLIC_PATH = 'https://schoolnext.colegiomixtosantarosa.com/';
//const PUBLIC_PATH = 'https://schoolnext.windsorschool.edu.co/';
define('PUBLIC_PATH', substr($_SERVER['SCRIPT_NAME'], 0, -9)); // - index.php string[9]  LOCAL

//$url = $_SERVER['ORIG_PATH_INFO'] ?? '/'; // WINDSOR
$url = $_SERVER['PATH_INFO'] ?? '/';  // LOCAL y SANTAROSA

const INSTITUTION_KEY = "development"; // "santarosa" "windsor" "development" En minúsculas

require APP_PATH . 'libs/bootstrap.php'; //bootstrap de app