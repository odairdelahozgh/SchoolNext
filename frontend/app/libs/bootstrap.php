<?php
// Bootstrap de la aplicacion para personalizarlo
// Para cargar cambia en public/index.php el require del bootstrap a app

// Arranca KumbiaPHP

/* HOSTING
const ABS_PUBLIC_PATH = '/home/windsor1/schoolnext.windsorschool.edu.co/';
*/


const APP_ROOT_PRIVATE = '/home/windsor1/schoolnext_private/';
define('VENDOR_PATH', APP_PATH.'../vendor/');
//const VENDOR_PATH      = APP_ROOT_PRIVATE.'frontend/vendor/';

const ABS_PUBLIC_PATH = 'D:\schoolnext\frontend\public'; // '/home/windsor1/schoolnext.windsorschool.edu.co/';

const SCHOOLWEB_PUBLIC_PATH = 'https://windsortemp.schoolnext.space/';
const APP_NAME= "SchoolNEXT>>";

const FILE_UPLOAD_PATH   = PUBLIC_PATH.'files/upload/';
const FILE_DOWNLOAD_PATH = PUBLIC_PATH.'files/download/';

const IMG_UPLOAD_PATH    = PUBLIC_PATH.'img/upload/';
const IMG_DOWNLOAD_PATH  = PUBLIC_PATH.'img/download/';
const IMG_ESTUDIANTES_PATH  = IMG_UPLOAD_PATH.'estudiantes';

require_once CORE_PATH . 'kumbia/bootstrap.php';