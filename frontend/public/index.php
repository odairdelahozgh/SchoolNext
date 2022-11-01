<?php
setlocale(LC_ALL, 'es_ES');
ini_set('date.timezone', 'America/Bogota');
const APP_CHARSET = 'UTF-8';

/*
// =======================
// SERVIDOR
const PRODUCTION = true;
//error_reporting(E_ALL ^ E_STRICT);ini_set('display_errors', 'On');
const APP_PATH        = '/home2/dwsjrnmy/_windsor_schoolnext_private/frontend/app/';
const CORE_PATH       = '/home2/dwsjrnmy/_windsor_schoolnext_private/core/';
const PUBLIC_PATH     = 'https://windsor.schoolnext.space/';
const ABS_PUBLIC_PATH = '/home2/dwsjrnmy/public_html/windsor_schoolnext_public';
// END - SERVIDOR
// =======================
*/


// =======================
// DESARROLLO LOCAL
const PRODUCTION = false;
//error_reporting(E_ALL ^ E_STRICT);ini_set('display_errors', 'On');
define('APP_PATH', dirname(__DIR__).'/app/');
define('CORE_PATH', dirname(dirname(APP_PATH)).'/core/');
define('PUBLIC_PATH', substr($_SERVER['SCRIPT_NAME'], 0, -9)); // - index.php string[9]
const ABS_PUBLIC_PATH = 'D:\schoolnext\frontend\public';
// END - DESARROLLO LOCAL
// =======================

$url = $_SERVER['PATH_INFO'] ?? '/';
require CORE_PATH.'kumbia/bootstrap.php'; //bootstrap del core
