<?php
//app/libs/lite_record.php

/**
 * Record 
 * Para los que prefieren SQL con las ventajas de ORM
 *
 * Clase padre para añadir tus métodos
 *
 * @category Kumbia
 * @package ActiveRecord
 * @subpackage LiteRecord
 */

//use Kumbia\ActiveRecord\LiteRecord as ORM;

class LiteRecord extends \Kumbia\ActiveRecord\LiteRecord
{    
    protected static $_defaults = array();
    protected static $_labels = array();
    protected static $_placeholders = array();
    protected static $_helps = array();
    protected static $_attribs = array();
    
    public function getFormName($clase)  { 
        $plural = $clase[strlen($clase)-1] == 's' ? $clase: $clase.'s';
        return strtolower($plural);
    }

    public function getDefault($field)     { return ((array_key_exists($field, self::$_defaults)) ? self::$_defaults[$field] : null); }
    public function getLabel($field)       { return ((array_key_exists($field, self::$_labels)) ? self::$_labels[$field] : $field.': '); }
    public function getPlaceholder($field) { return ((array_key_exists($field, self::$_placeholders)) ? self::$_placeholders[$field] : ''); }
    public function getHelp($field)        { return ((array_key_exists($field, self::$_helps)) ? self::$_helps[$field]: ''); }
    public function getAttrib($field)      { return ((array_key_exists($field, self::$_attribs)) ? self::$_attribs[$field]: ''); }
    
    //public function getDefaults()     { return self::$_defaults; }
    //public function getLabels()       { return self::$_labels; }
    //public function getPlaceholders() { return self::$_placeholders; }
    //public function getHelps()        { return self::$_helps; }
    //public function getAttribs()      { return self::$_attribs; }
    
    public static function valor_moneda($valor){
      return '$'.number_format($valor);
    }

      
    //=========
    const IS_ACTIVE = [
        0 => 'Inactivo',
        1 => 'Activo'
    ];

    public function ico_is_active($attr="w3-small") {
        return (($this->is_active) ? '<span class="w3-text-green">'._Icons::solid('check',$attr).'</span>' : '<span class="w3-text-red">'._Icons::solid('xmark',$attr).'</span>');
    }

    public function is_active_f($show_ico=false) {
        $ico = ($show_ico) ? $this->ico_is_active() : '' ;
        return $ico.'&nbsp;'.self::IS_ACTIVE[$this->is_active];
    }

    public function uniqidReal($lenght) {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
    
    
    public function setUuidAll_ojo($long=13) {
      $Todos = $this::all();
      foreach ($Todos as $key => $reg) {
        $reg->uuid = $this->uniqidReal($long);
        $reg->update();
      }
    } // END-setUuid()


    /**
     * Eliminar registro por uuid.
     * @param  string    $uuid valor para clave primaria uuid
     * @return bool
     */
    public static function deleteUuid($uuid): bool {
        $source  = static::getSource();
        return static::query("DELETE FROM $source WHERE uuid = ?", [$uuid])->rowCount() > 0;
    }

    public static function now(){
        return date('Y-m-d H:i:s', time());
    }
}