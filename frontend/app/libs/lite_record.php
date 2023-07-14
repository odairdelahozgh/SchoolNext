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

use Kumbia\ActiveRecord\LiteRecord as ORM;
require_once "enums.php";

class LiteRecord extends \Kumbia\ActiveRecord\LiteRecord
{ 
  protected static $_user_id = 0;
  protected static $_username = '';
  protected static $lim_tam_campo_uuid = 36;
  protected static $tam_campo_uuid = 30;    
  protected static $order_by_default = 't.id';
  protected static $class_name = __CLASS__;
  protected static $_periodo_actual = 0;
  protected static $_annio_actual = 0;
  const LIM_PAGO_PERIODOS = [ 1=>4, 2=>6, 3=>9, 4=>11, 5=>11 ];
  const SEXO          = ['M'=>'Masculino', 'F'=>'Femenino'];
  const IS_ACTIVE     = [0 =>'Inactivo', 1=>'Activo'];
  const ICO_IS_ACTIVE = [0=>'face-frown', 1=>'face-smile'];

  public function __construct() {
    self::$_user_id = Session::get('id');
    self::$_username = Session::get('username');
    self::$_periodo_actual = Session::get('periodo');
    self::$_annio_actual = Session::get('annio');
  } // END-__construct
  
  public function __toString() { return $this->id; }
  
  public function _beforeCreate() { // ANTES de Crear el Registro
    $ahora = date('Y-m-d H:i:s', time());
    if (property_exists($this, 'is_active'))  { $this->is_active = 1; }
    if (property_exists($this, 'uuid')) { 
      if (method_exists($this, 'setUUID')) { $this->uuid = $this->setUUID(); }
    }
    if (property_exists($this, 'created_by')) { $this->created_by = self::$_user_id; }
    if (property_exists($this, 'created_at')) { $this->created_at = $ahora; }
    if (property_exists($this, 'updated_by')) { $this->updated_by = self::$_user_id; }
    if (property_exists($this, 'updated_at')) { $this->updated_at = $ahora; }
  } // END-_beforeCreate
  
  public function _beforeUpdate() { // ANTES de actualizar el registro
    $ahora = date('Y-m-d H:i:s', time());
    if (property_exists($this, "is_active")) {
      if (is_null($this->is_active)) { $this->is_active = 0; }
    }
    if (property_exists($this, 'uuid')) {
      if (method_exists($this, 'setUUID')) { 
        if (is_null($this->uuid) or (strlen($this->uuid)==0)) { $this->setUUID(); }
      }
    }
    if (property_exists($this, 'updated_by')) { $this->updated_by = self::$_user_id; }
    if (property_exists($this, 'updated_at')) { $this->updated_at = $ahora; }
  } // END-_beforeCreate
  
  public function _afterUpdate() { // DESPUÉS de ACTUALIZAR el Registro
  } // END-_afterUpdate
  
  public function _afterCreate() { // DESPUÉS de CREAR el Registro
  } // END-_afterUpdate
  

  public function getList(int|bool $estado=null, string $select='*', string|bool $order_by=null) {
     $DQL = new OdaDql(_from: self::$class_name);
     $DQL->select( $select)
         ->orderBy( self::$order_by_default);
    if (!is_null(value: $order_by)) { $DQL->orderBy( $order_by); }
    if (!is_null(value: $estado))   { 
      $DQL->where( 't.is_active=?')
      ->setParams(params: [$estado]);
    }
    return $DQL->execute();
  } // END-getList

  public function getListActivos(string $select='*', string|bool $order_by=null): array|string {
    return $this->getList(1,  $select, $order_by);
  } //END-getListActivos

  public function getListInactivos(string $select='*', string|bool $order_by=null): array|string {
    return $this->getList(0,  $select, $order_by);
  } //END-getListInactivos


  public function is_active_f(bool $show_ico=false, string $attr="w3-small"): string {
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

   public function is_active_enum(bool $show_ico=false, string $attr="w3-small"): string {
     $estado = Estado::tryFrom((int)$this->is_active) ?? Estado::Inactivo;
    return '<span class="'.$attr.' w3-text-'.$estado->color().'">'. (($show_ico) ? $estado->label_ico() : $estado->label()).'</span>';
   }

   
   public function nombre_mes_enum(int $mes): string {
    $nombre_mes = Mes::tryFrom(value: $mes) ?? Mes::Enero;
   return $nombre_mes->label();
  }

  /**
   * Activar un registro.
   */
  public function setActivar(): bool {
    try {
      $this->is_active = 1;
      $this->save();
      return true;
    } catch (\Throwable $th) {
      throw $th;
      return false;
    }
  } // END-setActivar
    
  /**
   * Desactivar un registro
   */
  public function setDesactivar(): bool {
    try {
      $this->is_active = 0;
      $this->save();
      return true;
    } catch (\Throwable $th) {
      throw $th;
      return false;
    }
  } // END-setDesactivar
    
  
  /**
   * Devuelve un numero con formato moneda.
   */
  public static function valor_moneda(int $val_num): string {
    return '$'.number_format($val_num);
  } //END-valor_moneda
  
  /**
   * Devuelve un numero convertido en letras
   */
  public function valor_letras(int $val_num): string {
    return strtolower(OdaUtils::getNumeroALetras($val_num));
  } //END-valor_letras

      
} //END-CLASS