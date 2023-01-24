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
  protected static $session_user_id = 0;
  protected static $session_username = '';
  protected static $lim_tam_campo_uuid = 36;
  protected static $tam_campo_uuid = 30;
  
  const SEXO = [
    'M' => 'Masculino',
    'F' => 'Femenino',
  ];
  const IS_ACTIVE = [
    0 => 'Inactivo',
    1 => 'Activo',
  ];
  
  const ICO_IS_ACTIVE = [
    0 => 'face-frown', //check
    1 => 'face-smile', //xmark
  ];

  public function __construct() {
    self::$session_user_id = Session::get('id');
    self::$session_username = Session::get('username');
  }
  
  public function __toString() { return $this->id; }
  
  public function _beforeCreate() { // ANTES de Crear el Registro
    $ahora = date('Y-m-d H:i:s', time());
      $this->created_by = self::$session_user_id;
      $this->updated_by = self::$session_user_id;
      $this->created_at = $ahora;
      $this->updated_at = $ahora;
      $this->is_active = 1;
    }
        
    public function _beforeUpdate() { // ANTES de actualizar el registro
      if (is_null($this->is_active)) { $this->is_active = 0; }
      $this->updated_by = self::$session_user_id;
      $this->updated_at = date('Y-m-d H:i:s', time());
    }

    public function _afterUpdate() { // DESPUÉS de ACTUALIZAR el Registro
    }
    
    public function getDefault($field)     { return ((array_key_exists($field, self::$_defaults)) ? self::$_defaults[$field] : null); }
    public function getLabel($field)       { return ((array_key_exists($field, self::$_labels)) ? self::$_labels[$field] : $field.': '); }
    public function getPlaceholder($field) { return ((array_key_exists($field, self::$_placeholders)) ? self::$_placeholders[$field] : ''); }
    public function getHelp($field)        { return ((array_key_exists($field, self::$_helps)) ? self::$_helps[$field]: ''); }
    public function getAttrib($field)      { return ((array_key_exists($field, self::$_attribs)) ? self::$_attribs[$field]: ''); }
    
    public function getIsActiveF(bool $show_ico=false, string $attr="w3-small"): string {
      $estado = self::IS_ACTIVE[(int)$this->is_active] ?? 'Inactivo';
      $ico    = '';
      if ($show_ico) {
        $ico = match((int)$this->is_active) {
          0   => '<span class="w3-text-red">'._Icons::solid(self::ICO_IS_ACTIVE[0], $attr).'</span> ',
          1 => '<span class="w3-text-green">'  ._Icons::solid(self::ICO_IS_ACTIVE[1], $attr).'</span> '
        };
      }
      return $ico.$estado;
    }

    public function setActivar(): bool {
      $this->is_active = 1;
      $this->save();
      return true;
    } // END-setActivar
    
    public function setDesactivar(): bool {
      $this->is_active = 0;
      $this->save();
      return true;
    } // END-setActivar

    
    /**
     * Eliminar registro por 'id'.
     * @param  int   $id valor para clave primaria id
     * @return bool
     */
    public static function deleteID(int $id): bool {
        $source  = static::getSource();
        return static::query("DELETE FROM $source WHERE id = ?", [$id])->rowCount() > 0;
    }

    /**
     * Buscar por UUID.
     *
     * @param  string       $uuid valor para clave primaria
     * @param  string       $fields campos que se desean obtener separados por coma
     * 
     * @return self|false
     */
/*     public static function get_uuid(string $uuid, string $fields = '*') {
        $sql = "SELECT $fields FROM ".static::getSource().' WHERE uuid = ?';
        return static::query($sql, [$uuid])->fetch();
    }
  */
  
    /**
     * Buscar por PK ID.
     *
     * @param  int       $id valor para clave primaria
     * @param  string    $fields campos que se desean obtener separados por coma
     * 
     * @return self|false
     */
    public static function get_id(int $id, string $fields = '*') {
        $sql = "SELECT $fields FROM ".static::getSource().' WHERE id = ?';
        return static::query($sql, [$id])->fetch();
    }

    public static function valor_moneda($valor){
        return '$'.number_format($valor);
    }
  
    public function aLetras($valor) {
          return strtolower(OdaUtils::getNumeroALetras($valor));
    }

      
}