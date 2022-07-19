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

// $this->name => $this->value
// Estado::cases();

/**
 * @link https://www.php.net/manual/es/language.enumerations.expressions.php
 */
enum Estado: int {
    case Activo   = 1;
    case Inactivo = 0;
    
    public function label(): string {
        return match($this) {
            static::Activo   => 'Activo',
            static::Inactivo => 'Inactivo',
        };
    }
    
    public function labelIcon($attr="w3-small"): string {
        return match($this) {
            static::Activo   => '<span class="w3-text-green">'._Icons::solid('check',$attr).'</span> '.$this->label(),
            static::Inactivo => '<span class="w3-text-red">'  ._Icons::solid('xmark',$attr).'</span> '.$this->label(),
        };
    }

}


class LiteRecord extends \Kumbia\ActiveRecord\LiteRecord
{    
    protected static $_defaults = array();
    protected static $_labels = array();
    protected static $_placeholders = array();
    protected static $_helps = array();
    protected static $_attribs = array();
    protected static $session_user_id = 0;

    public function __construct() {
        self::$session_user_id = Session::get('id');
    }

    public function _beforeCreate() { // ANTES de CREAR el nuevo registro
        $ahora = date('Y-m-d H:i:s', time());
        $this->uuid = $this->UUIDReal(20);
        $this->created_by = self::$session_user_id;
        $this->updated_by = self::$session_user_id;
        $this->created_at = $ahora;
        $this->updated_at = $ahora;
        $this->is_active = 1;
    }
      
    public function _beforeUpdate() { // ANTES de ACTUALIZAR el registro
        if (strlen($this->uuid)==0) { $this->uuid = $this->UUIDReal(20); }
        $this->updated_by = self::$session_user_id;
        $this->updated_at = date('Y-m-d H:i:s', time());
    }
    
    //public function _afterCreate() { }
    //public function _afterUpdate() { }
    
    public function getDefault($field)     { return ((array_key_exists($field, self::$_defaults)) ? self::$_defaults[$field] : null); }
    public function getLabel($field)       { return ((array_key_exists($field, self::$_labels)) ? self::$_labels[$field] : $field.': '); }
    public function getPlaceholder($field) { return ((array_key_exists($field, self::$_placeholders)) ? self::$_placeholders[$field] : ''); }
    public function getHelp($field)        { return ((array_key_exists($field, self::$_helps)) ? self::$_helps[$field]: ''); }
    public function getAttrib($field)      { return ((array_key_exists($field, self::$_attribs)) ? self::$_attribs[$field]: ''); }
    
    // //=========
    // const IS_ACTIVE = [
    //     0 => 'Inactivo',
    //     1 => 'Activo',
    // ];

    public function is_active_f($show_ico=false) {
        $estado = Estado::from((int)$this->is_active) ?? Estado::Inactivo;
        return $estado->labelIcon();
    }

    //Universally Unique IDentifier Generator optimized
    public function UUIDReal(int $lenght):string {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
    
    
    public function setUUID_All_ojo($long=13) {
      $Todos = $this::all();
      foreach ($Todos as $key => $reg) {
        $reg->uuid = $this->UUIDReal($long);
        $reg->update();
      }
    } // END-setUuid()


    /**
     * Eliminar registro por uuid.
     * @param  string    $uuid valor para clave primaria uuid
     * @return bool
     */
    public static function deleteUUID($uuid): bool {
        $source  = static::getSource();
        return static::query("DELETE FROM $source WHERE uuid = ?", [$uuid])->rowCount() > 0;
    }
 
    public static function valor_moneda($valor){
        return '$'.number_format($valor);
    }
  
    public function aLetras($valor) {
          return strtolower(OdaUtils::getNumeroALetras($valor));
    }
    
      
}