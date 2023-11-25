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

  
class Usuario extends LiteRecord {

  use UsuarioTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.usuario');
    self::$_order_by_defa = 't.is_active DESC, t.apellido1, t.apellido2, t.nombres';
    $this->setUp();
  } //END-__construct
  
  public function misGrupos() { // int $user_id // mejorar !!!
    try {

      $user_id = Session::get('id');
      if (false !== ( (new Salon)::first('Select t.id from sweb_salones as t where t.director_id=? or t.codirector_id=?', [$user_id, $user_id]) ) ) {
        return (new Salon)::filter('WHERE is_active=1 AND director_id=? OR codirector_id=?', [$user_id, $user_id]) ;
      }
      return [];


      // if (1==$user_id) { //admin
      //   $dirigidos = (new Salon)::all('Select t.id from sweb_salones as t where t.is_active=1');
      // } else {
      //   $dirigidos = (new Salon)::all('Select t.id from sweb_salones as t where t.is_active=1 and (t.director_id=? or t.codirector_id=?)', [$user_id, $user_id]);
      // }
      
      // if (false !== $dirigidos ) {
      //   return $dirigidos;
      // }
      // return [];

    //return $DQL->execute();

  } catch (\Throwable $th) {
    OdaFlash::error($th);
  }
}



public function setPassword(string $seed=null) {
  try {
    $salt = md5(rand(100000, 999999).$this->username);
    $this->salt = $salt;
    
    if (is_null($seed)) {
      $seed = ($this->documento == $this->username) ? $this->documento: substr($this->documento, -4);  // true:padres  false:empleados
    }

    $password_salt = hash('sha1', $salt . $seed);
    $this->password = $password_salt;
    $this->update();

    $rec_count = $this::query("UPDATE ".self::$table." SET password=? WHERE id=? ", [$password_salt, $this->id])->rowCount();
    OdaFlash::info("\nUsername: $this->username \nId: $this->id \nDocumento: $this->documento \nPassword:  $pass \nSALT: $this->salt \nPassword SALT $password_salt \nAfect: $rec_count", true);
  } catch (\Throwable $th) {
    OdaFlash::error($th);
  }

} //END-setPassword



} //END-CLASS