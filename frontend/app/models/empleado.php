<?php
/**
 * Modelo Empleado
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

  
//class Empleado extends LiteRecord {
class Empleado extends Usuario {

  //use EmpleadoTraitSetUp;

  public function getList(int|bool $estado=null, $select='*', string|bool $order_by=null) { 
    $DQL = new OdaDql('usuario');
    $DQL->select("t.*")
      ->concat(['t.apellido1', 't.apellido2', 't.nombres'], 'usuario_nombre')
      ->concat(['t.apellido1', 't.apellido2', 't.nombres'], 'nombre')
      ->where('t.username<>t.documento')
      ->orderBy(self::$_order_by_defa);

    if (!is_null($estado)) { $DQL->andWhere("t.is_active=$estado"); }

    if (!is_null($order_by)) { 
      $DQL->orderBy($order_by); 
    }
    return $DQL->execute();
  }//END-getList


} //END-CLASS