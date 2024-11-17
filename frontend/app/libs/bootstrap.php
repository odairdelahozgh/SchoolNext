<?php
// Bootstrap de la aplicacion para personalizarlo
// Para cargar cambia en public/index.php el require del bootstrap a app
// Arranca KumbiaPHP

const VENDOR_PATH = APP_PATH.'../vendor/' ;
const HELPERS_PATH = APP_PATH.'extensions/helpers/' ;

//const ABS_PUBLIC_PATH  = '/home/u113041793/domains/colegiomixtosantarosa.com/public_html/_schoolnext_website';  // SANTAROSA
//const ABS_PUBLIC_PATH = '/home/tecnoro1/schoolnext.tecnorobotica.com';  // WINDSOR
const ABS_PUBLIC_PATH = 'D:\schoolnext\frontend\public'; // LOCAL

const APP_NAME= "SchoolNEXT>>";
const INSTITUTION_KEY = "windsor"; // "santarosa" "windsor" En minúsculas 

const FILE_UPLOAD_PATH   = PUBLIC_PATH.'files/upload/';
const FILE_DOWNLOAD_PATH = PUBLIC_PATH.'files/download/';

const IMG_UPLOAD_PATH    = PUBLIC_PATH.'img/upload/';
const IMG_DOWNLOAD_PATH  = PUBLIC_PATH.'img/download/';
const IMG_ESTUDIANTES_PATH  = IMG_UPLOAD_PATH.'estudiantes/';

require_once CORE_PATH . 'kumbia/bootstrap.php';