<?php
/**
 *
 * Extension para el manejo de mensajes sin hacer uso del "echo" en los controladores o modelos
 *
 * @category    Flash
 * @package     Helpers
 *  
 * Se utiliza en el método content de la clase view.php 
 * 
 * OdaFlash::output();
 * 
 */

class OdaFlash {
    
    /**
     * Mensajes almacenados en un request
     */
    private static $_contentMsj = array();
    
    protected static $icons = array(
        'success' => 'hands-clapping', 'info' => 'bell',
        'warning' => 'circle-exclamation', 'danger' => 'x',
    );
    protected static $themes = array(
        'success'=>'w3-pale-green', 'info'=>'w3-pale-blue', 
        'warning'=>'w3-pale-yellow', 'danger'=>'w3-pale-red'
    );

    /**
     * Setea un mensaje
     *
     * @param string $name Tipo de mensaje y para CSS class='$name'.
     * @param string $msg Mensaje a mostrar
     * @param boolean $audit Indica si el mensaje se almacena como auditoría
     */
    public static function set($name, $msg, $audit=FALSE) { 
        $color = self::$themes[$name];
        $icon  = '<i class="fa fa-'.self::$icons[$name].'"></i>&nbsp; ';
        //Verifico si hay mensajes almacenados en sesión por otro request.
        if(self::hasMessage()) {            
            self::$_contentMsj = Session::get('flash_message');                
        }        
        //Guardo el mensaje en el array
        if (isset($_SERVER['SERVER_SOFTWARE'])) {                    
            $tmp_id              = round(1, 5000);
            self::$_contentMsj[] = "<div id=\"alert-id-$tmp_id\" class=\"w3-panel w3-display-container w3-round $color\">
                              <span onclick=\"this.parentElement.style.display='none'\"
                              class=\"w3-button w3-large w3-display-topright\">&times;</span>
                              <p>$icon $msg</p>
                            </div>";
        } else {
            self::$_contentMsj[] = $name.': '.Filter::get($msg, 'striptags').PHP_EOL;            
        }        
        //Almaceno los mensajes guardados en una variable de sesión, para mostrar los mensajes provenientes de otro request.
        Session::set('flash_message', self::$_contentMsj);
        if($audit) {  //Verifico si el mensaje se almacena como looger (auditoria)
            if($name=='success') {
                //DwAudit::debug($msg);
                OdaLog::set('INFO', $msg, '');
            } else if($name=='danger') {
                //DwAudit::error($msg);
                OdaLog::set('DEBUG', $msg, '');
            } else {
                //DwAudit::$name($msg);                
                OdaLog::set('ERROR', $msg, '');             
            }
        }            
    }
    
    /**
     * Verifica si tiene mensajes para mostrar.
     *
     * @return bool
     */
    public static function hasMessage() {
        return Session::has('flash_message') ?  TRUE : FALSE;
    }
    
    /**
     * Método para limpiar los mensajes almacenados
     */
    public static function clean() {
        self::$_contentMsj = array(); //Reinicio la variable de los mensajes
        Session::delete('flash_message'); //Elimino los almacenados en sesión
    }

    /**
     * Muestra los mensajes
     */
    public static function output() {
        if(OdaFlash::hasMessage()) {
            $tmp_msg = Session::get('flash_message');
            foreach($tmp_msg as $msg) { //Recorro los mensajes
                echo $msg; // Imprimo los mensajes
            }
            self::clean();
        }
    }
    
    /**
     * Retorna los mensajes cargados como string
     */
    public static function toString() {        
        //Asigno los mensajes almacenados en sesión en una variable temporal
        $tmp = self::hasMessage() ? Session::get('flash_message') : array();
        $msg = array();
        //Recorro los mensajes
        foreach($tmp as $item) {            
            //Limpio los mensajes
            $item  = explode('<script', $item);
            if(!empty($item[0])) {
                $msg[] = str_replace('×', '', Filter::get($item[0], 'striptags'));                
            }
        }
        $flash = Filter::get(ob_get_clean(), 'striptags', 'trim'); //Almaceno los mensajes que hay en el buffer por los echo
        $msg = Filter::get(join('<br />', $msg), 'trim');
        self::clean(); //Limpio los mensajes de la sesión               
        return ($flash) ? $flash.'<br />'.$msg : $msg;        
    }

    /**
     * Carga un mensaje de error
     *
     * @param string $msg
     * @param boolean $autid Indica si se registra el mensaje como una auditoría
     */
    public static function error($msg, $audit=FALSE) {
        self::set('danger',$msg, $audit);          
    }

    /**
     * Carga un mensaje de advertencia en pantalla
     *
     * @param string $msg
     * @param boolean $autid Indica si se registra el mensaje como una auditoría
     */
    public static function warning($msg, $audit=FALSE) {
        self::set('warning',$msg, $audit);
    }

    /**
     * Carga informacion en pantalla
     *
     * @param string $msg
     * @param boolean $autid Indica si se registra el mensaje como una auditoría
     */
    public static function info($msg, $audit=FALSE) {
        self::set('info',$msg, $audit);
    }
    
    /**
     * Carga información de suceso correcto en pantalla
     *
     * @param string $msg
     * @param boolean $autid Indica si se registra el mensaje como una auditoría
     */
    public static function valid($msg, $audit=FALSE) {
        self::set('success',$msg, $audit);
    }    
    
}
