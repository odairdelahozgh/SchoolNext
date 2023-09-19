<?php
/**
 * Modelo Usuario
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * 
 * id, uuid, username, roll, nombres, apellido1, apellido2, photo, profesion, direccion, documento, email, 
 * telefono1, telefono2, cargo, sexo, fecha_nac, fecha_ing, fecha_ret, observacion, is_carga_acad_ok, 
 * is_partner, usuario_instit, clave_instit, theme, 
 * algorithm, salt, password, is_super_admin, last_login, forgot_password_code, 
 * is_active, created_at, updated_at,  
 */

  
class Padre extends LiteRecord {

  use PadreTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.usuario');
    self::$_order_by_defa = 't.username';
    $this->setUp();
  } //END-__construct

  
  public function getList(int|bool $estado=null, string $select='*', string|bool $order_by=null) {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select($select)
        ->where('t.username=t.documento')
        ->orderBy(self::$_order_by_defa);

   if (!is_null($order_by)) { $DQL->orderBy($order_by); }
   if (!is_null($estado)) { 
     $DQL->AndWhere('t.is_active=?')
         ->setParams([$estado]);
   }
   return $DQL->execute();
 } // END-getList
  
} //END-CLASS