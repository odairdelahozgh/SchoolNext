<?php
setlocale(LC_ALL, 'es_ES');
ini_set('date.timezone', 'America/Bogota');
const APP_CHARSET = 'UTF-8';

/*
// =======================
// SERVIDOR - Bluehost Odair
const PRODUCTION = true;
//error_reporting(E_ALL ^ E_STRICT);
//ini_set('display_errors', 'On');
const APP_ROOT_PRIVATE = '/home2/dwsjrnmy/_windsor_schoolnext_private/';
const APP_PATH         = APP_ROOT_PRIVATE.'frontend/app/';
const CORE_PATH        = APP_ROOT_PRIVATE.'core/';
const PUBLIC_PATH      = 'https://windsor.schoolnext.space/';

$url = $_SERVER['PATH_INFO'] ?? '/';

const VENDOR_PATH      = APP_ROOT_PRIVATE.'vendor/';
const ABS_PUBLIC_PATH  = '/home2/dwsjrnmy/public_html/windsor_schoolnext_public';
const SCHOOLWEB_PUBLIC_PATH = 'https://windsortemp.schoolnext.space/';
*/

/*
// =======================
// SERVIDOR - Windsor - Rafa
const PRODUCTION = true;
//error_reporting(E_ALL ^ E_STRICT);ini_set('display_errors', 'On');
const APP_ROOT_PRIVATE = '/home/windsor1/schoolnext_private/';
const APP_PATH         = APP_ROOT_PRIVATE.'frontend/app/';
const CORE_PATH        = APP_ROOT_PRIVATE.'core/';
const PUBLIC_PATH     = 'https://schoolnext.windsorschool.edu.co/';
$url = $_SERVER['ORIG_PATH_INFO'] ?? '/';

const VENDOR_PATH      = APP_ROOT_PRIVATE.'vendor/';
const ABS_PUBLIC_PATH = '/home/windsor1/schoolnext.windsorschool.edu.co/';
const SCHOOLWEB_PUBLIC_PATH = 'https://schoolweb.windsorschool.edu.co/';
*/


// =======================
// DESARROLLO LOCAL
const PRODUCTION = false;
error_reporting(E_ALL ^ E_STRICT);ini_set('display_errors', 'On');
define('APP_PATH', dirname(__DIR__).'/app/');
define('CORE_PATH', dirname(dirname(APP_PATH)).'/core/');
define('PUBLIC_PATH', substr($_SERVER['SCRIPT_NAME'], 0, -9)); // - index.php string[9]
$url = $_SERVER['PATH_INFO'] ?? '/';

define('VENDOR_PATH', APP_PATH.'../vendor/');
const ABS_PUBLIC_PATH = 'D:\schoolnext\frontend\public';
const SCHOOLWEB_PUBLIC_PATH = 'D:\windsortemp\web';


const APP_NAME= "SchoolNEXT>>";
const FILE_UPLOAD_PATH   = PUBLIC_PATH.'files/upload/';
const FILE_DOWNLOAD_PATH = PUBLIC_PATH.'files/download/';
const IMG_UPLOAD_PATH    = PUBLIC_PATH.'img/upload/';
const IMG_DOWNLOAD_PATH  = PUBLIC_PATH.'img/download/';

require CORE_PATH.'kumbia/bootstrap.php'; //bootstrap del core


/*
..public/windsorviejo_schoolnext_public    ====>  public
..uploads/aspirantes_adjuntos         ====>  .../files/upload/aspirantes_adjuntos
..uploads/aspirantes_adjuntos_2021    ====>  .../files/upload/aspirantes_adjuntos
..uploads/estud_reg_des_aca_com       ====> .../files/upload/estud_reg_des_aca_com
..uploads/estud_reg_observ_gen        ====> .../files/upload/estud_reg_observ_gen
..uploads/matriculas_adjuntos         ====> .../files/upload/matriculas_adjuntos
..uploads/matriculas_adjuntos_2       ====> .../files/upload/matriculas_adjuntos
..uploads/student                     ====> .../img/upload/estudiantes [FOTOS DE LOS ESTUDIANTES]
..uploads/dm_user                     ====> .../img/upload/users [FOTOS DE LOS PROFESORES USUARIOS DEL SISTEMA]
*/