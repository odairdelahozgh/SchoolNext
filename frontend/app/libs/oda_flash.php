<?php
/**
 * Extension para el manejo de mensajes sin hacer uso del "echo" en los controladores o modelos
 * @category  Flash
 * @package   Helpers
 * Se utiliza en el método content de la clase view.php
 * OdaFlash::output();
 */

class OdaFlash {
  private static $_contentMsj = array();
  
  protected static $icons = array(
    'error' => 'x',
    'warning' => 'circle-exclamation', 
    'info' => 'bell',
    'valid' => 'hands-clapping', 
  );
  protected static $themes = array(
    'error'=>'w3-pale-red',
    'warning'=>'w3-pale-yellow', 
    'info'=>'w3-pale-blue', 
    'valid'=>'w3-pale-green', 
  );

  protected static function UUIDReal(int $lenght=20): string {
    if (function_exists("random_bytes")) {
      $bytes = random_bytes(ceil($lenght / 2));
    } elseif (function_exists("openssl_random_pseudo_bytes")) {
      $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
    } else {
      throw new Exception("no cryptographically secure random function available");
    }
    return substr(bin2hex($bytes), 0, $lenght);
  }//END-UUIDReal
  
  public static function set(string $name, $msg, bool $audit=FALSE) { 
    $color = self::$themes[$name];
    $icon  = '<i class="fa fa-'.self::$icons[$name].'"></i>&nbsp; ';
    $uuid = self::UUIDReal();
    $lnk = OdaUtils::linkToSupportWhatsApp($uuid);

    if(self::hasMessage()) { self::$_contentMsj = Session::get('flash_message'); }    
    $message = '';
    switch ($name) {
      case 'error':
        $message = "<b>EXCEPCIÓN INTERNA CAPTURADA:</b> ".$msg->getMessage()."<br>$lnk";
        break;
      case 'warning':
        $message = $msg."<br>$lnk";
        break;
      default:
        $message = $msg;
        break;
    }


    if (isset($_SERVER['SERVER_SOFTWARE'])) { 
      $tmp_id  = round(1, 5000);
      self::$_contentMsj[] = "<div id=\"alert-id-$tmp_id\" class=\"w3-panel w3-display-container w3-round $color\">
                <span onclick=\"this.parentElement.style.display='none'\"
                class=\"w3-button w3-large w3-display-topright\">&times;</span>
                <p>$icon $message</p>
              </div>";
      //self::$_contentMsj[] = "<div class=\"alert alert-danger .has-icon\" role=\"alert\">$message</div>";
    } else {
      self::$_contentMsj[] = $name.': '.Filter::get($msg, 'striptags').PHP_EOL;      
    }

    Session::set('flash_message', self::$_contentMsj);

    if ($audit) {
      switch ($name) {
        case 'error':
          OdaLog::error($msg, $uuid);
          break;
        case 'warning':
          OdaLog::warning($msg, $uuid);
          break;
        case 'info':
          OdaLog::info($msg, $uuid);
          break;
        case 'valid':
          OdaLog::notice($msg, $uuid);
          break;
      }
    }
    
  } //END-set
  

  public static function hasMessage() { // Verifica si tiene mensajes para mostrar.
    return Session::has('flash_message') ?  TRUE : FALSE;
  } //END-hasMessage

  public static function clean() { // Método para limpiar los mensajes almacenados
    self::$_contentMsj = array();
    Session::delete('flash_message');
  } //END-clean

  public static function output() { // Muestra los mensajes
    if(OdaFlash::hasMessage()) {
      $tmp_msg = Session::get('flash_message');
      foreach($tmp_msg as $msg) { //Recorro los mensajes
        echo $msg; // Imprimo los mensajes
      }
      self::clean();
    }
  }

  public static function toString() { // Retorna los mensajes cargados como string
    $tmp = self::hasMessage() ? Session::get('flash_message') : array();
    $msg = array();
    
    foreach($tmp as $item) { // Recorro los mensajes
      $item  = explode('<script', $item);
      if(!empty($item[0])) {
        $msg[] = str_replace('×', '', Filter::get($item[0], 'striptags'));        
      }
    }
    $flash = Filter::get(ob_get_clean(), 'striptags', 'trim'); // Almaceno los mensajes que hay en el buffer (por los echo)
    $msg = Filter::get(join('<br />', $msg), 'trim');
    self::clean();
    return ($flash) ? $flash.'<br />'.$msg : $msg;
  }

  public static function error(Throwable $msg, $audit=TRUE) {
    self::set('error',$msg, $audit);
  } //END-error
  
  public static function warning(string $msg, $audit=TRUE) {
    self::set('warning','<b>ATENCI&Oacute;N: FALL&Oacute; OPERACI&Oacute;N:</b> '.$msg, $audit);
  } //END-warning

  public static function info(string $msg, $audit=FALSE) {
    self::set('info','<b>Aviso informativo:</b> '.$msg, $audit);
  } //END-info
  
  public static function valid(string $msg, $audit=FALSE) {
    self::set('valid','<b>Operaci&oacute;n exitosa:</b> '.$msg, $audit);
  } //END-valid
  

} //END-class