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

  
class Empleado extends LiteRecord {

  use EmpleadoTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.usuario');
    self::$order_by_default = 't.is_active DESC, t.created_at DESC';
    $this->setUp();
  } //END-__construct

 public function getList(int|bool $estado=null, $select='*', string|bool $order_by=null) { 
  $DQL = new OdaDql('usuario');
  $DQL->select("t.*")
      ->concat(concat: ['t.nombres', 't.apellido1', 't.apellido2'], alias:'nombre')
      ->where('t.username<>t.documento')
      ->orderBy(self::$order_by_default);

  if (!is_null($estado)) { $DQL->andWhere("t.is_active=$estado"); }

  if (!is_null($order_by)) { 
    $DQL->orderBy($order_by); 
  }
  
  return $DQL->execute();
}

} //END-CLASS