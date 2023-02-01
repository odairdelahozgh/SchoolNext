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
  protected static string $order_by_default = 't.id ASC';
  protected static string $class_name = '';
  
  const SEXO = ['M'=>'Masculino', 'F'=>'Femenino'];
  const IS_ACTIVE = [0 =>'Inactivo', 1=>'Activo'];
  const ICO_IS_ACTIVE = [0=>'face-frown', 1=>'face-smile'];

  public function __construct() {
    self::$session_user_id = Session::get('id');
    self::$session_username = Session::get('username');
  } // END-__construct
  
  public function __toString() { return $this->id; }
  
  public function _beforeCreate() { // ANTES de Crear el Registro
    $ahora = date('Y-m-d H:i:s', time());
      $this->created_by = self::$session_user_id;
      $this->updated_by = self::$session_user_id;
      $this->created_at = $ahora;
      $this->updated_at = $ahora;
      $this->is_active = 1;
  } // END-_beforeCreate
  
  public function _afterCreate() { // DESPUÉS de CREAR el Registro
  } // END-_afterUpdate

  public function _beforeUpdate() { // ANTES de actualizar el registro
      if (is_null($this->is_active)) { $this->is_active = 0; }
      $this->updated_by = self::$session_user_id;
      $this->updated_at = date('Y-m-d H:i:s', time());
  } // END-_beforeCreate

  public function _afterUpdate() { // DESPUÉS de ACTUALIZAR el Registro
  } // END-_afterUpdate
    
  public function getDefault($field)     { return ((array_key_exists($field, self::$_defaults)) ? self::$_defaults[$field] : null); }
  public function getLabel($field)       { return ((array_key_exists($field, self::$_labels)) ? self::$_labels[$field] : $field.': '); }
  public function getPlaceholder($field) { return ((array_key_exists($field, self::$_placeholders)) ? self::$_placeholders[$field] : ''); }
  public function getHelp($field)        { return ((array_key_exists($field, self::$_helps)) ? self::$_helps[$field]: ''); }
  public function getAttrib($field)      { return ((array_key_exists($field, self::$_attribs)) ? self::$_attribs[$field]: ''); }
    
  /**
   * Devuelve is_active con formato
   */
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
  } // END-getIsActiveF

  public function is_active_f(bool $show_ico=false, string $attr="w3-small"): string {
    return $this->getIsActiveF($show_ico, $attr);
  }

  /**
   * Activar un registro inactivo.
   */
  public function setActivar(): bool {
    $this->is_active = 1;
    $this->save();
    return true;
  } // END-setActivar
    
  /**
   * Desactivar un registro
   */
  public function setDesactivar(): bool {
    $this->is_active = 0;
    $this->save();
    return true;
  } // END-setActivar
    
  /**
   * Eliminar registro por 'id'
   */
  public static function deleteById(int $id): bool {
    $source  = static::getSource();
    return static::query("DELETE FROM $source WHERE id = ?", [$id])->rowCount() > 0;
  } // END-deleteID
  
  /**|
   * Buscar por ID.
   * @return self|false
   */
  public static function getById(int $id, string $fields = '*') {
    $sql = "SELECT $fields FROM ".static::getSource().' WHERE id = ?';
    return static::query($sql, [$id])->fetch();
  } // END-get_id
      
  /**
   * Devuelve lista de todos los Registros.
   */
  public function getList(int|bool $estado=null, string $select='*', string|bool $order_by=null) {
    $DQL = (new OdaDql)
        ->select($select)
        ->from(from_class: self::$class_name)
        ->orderBy(self::$order_by_default);   
    if (!is_null($order_by)) { $DQL->orderBy($order_by); }
    if (!is_null($estado))   { 
      $DQL->where('t.is_active=?')
      ->setParams([$estado]);
    }
    return $DQL->execute();
  } // END-getList

  /**
   * Devuelve lista de Registros Activos.
   */
  public function getListActivos(string $select='*', string|bool $order_by=null): array|string {
    return $this->getList(estado: 1, select: $select, order_by: $order_by);
  } //END-getListActivos

  /**
   * Devuelve lista de Registros Inactivos.
   */
  public function getListInactivos(string $select='*', string|bool $order_by=null): array|string {
    return $this->getList(estado: 0, select: $select, order_by: $order_by);
  } //END-getListInactivos
    
  /**
   * Devuelve un numero con formato mo neda.
   */
  public static function valor_moneda(int $val_num): string {
    return '$'.number_format($val_num);
  } //END-valor_moneda
  
  /**
   * Devuelve un numero convertido en letras
   */
  public function aLetras(int $val_num): string {
    return strtolower(OdaUtils::getNumeroALetras($val_num));
  } //END-aLetras

      
} //END-CLASS