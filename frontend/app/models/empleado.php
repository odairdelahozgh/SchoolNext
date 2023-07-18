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
    self::$order_by_default = 't.is_active DESC, t.apellido1, t.apellido2, t.nombres';
    $this->setUp();
  } //END-__construct

  public function getList(int|bool $estado=null, $select='*', string|bool $order_by=null) { 
    $DQL = new OdaDql('usuario');
    $DQL->select("t.*")
      ->concat(['t.apellido1', 't.apellido2', 't.nombres'], 'usuario_nombre')
      ->concat(['t.apellido1', 't.apellido2', 't.nombres'], 'nombre')
      ->where('t.username<>t.documento')
      ->orderBy(self::$order_by_default);

    if (!is_null($estado)) { $DQL->andWhere("t.is_active=$estado"); }

    if (!is_null($order_by)) { 
      $DQL->orderBy($order_by); 
    }
    return $DQL->execute();
  }//END-getList

  public function getLista() { 
    $DQL = new OdaDql(__CLASS__);
    $DQL->select("t.*")
      ->concat(['t.apellido1', 't.apellido2', 't.nombres'], 'usuario_nombre')
      ->concat(['t.apellido1', 't.apellido2', 't.nombres'], 'nombre')
      ->where('t.username <> t.documento')
      ->orderBy(self::$order_by_default);

    return $DQL->execute();
  }//END-getList


public function setPassDocente() {
  try {
    $pass = substr($this->documento, -4);
    $password_salt = hash('sha1', $this->salt . $pass);
    $this->password = $password_salt;
    $this->update();

    //$rec_count = $this::query("UPDATE ".self::$table." SET password=? WHERE id=? ", [$password_salt, $this->id])->rowCount();
    //OdaFlash::info("\nUsername: $this->username \nId: $this->id \nDocumento: $this->documento \nPassword:  $pass \nSALT: $this->salt \nPassword SALT $password_salt \nAfect: $rec_count", true);
  } catch (\Throwable $th) {
    OdaFlash::error($th);
  }

} //END-setPassword



} //END-CLASS