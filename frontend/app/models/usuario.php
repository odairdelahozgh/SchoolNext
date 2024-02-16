<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

include "usuario/usuario_trait_props.php";
include "usuario/usuario_trait_set_up.php";
  
class Usuario extends LiteRecord {

  use UsuarioTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.usuario');
    self::$_order_by_defa = 't.is_active DESC, t.apellido1, t.apellido2, t.nombres';
    $this->setUp();
  }
  
  public function misGrupos(): array
  { // int $user_id // mejorar !!!
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


  public function getDocentes()
  { 
    $DQL = new OdaDql(__CLASS__);
    $DQL->select("t.*")
      ->concat(['t.apellido1', 't.apellido2', 't.nombres'], 'usuario_nombre')
      ->concat(['t.apellido1', 't.apellido2', 't.nombres'], 'nombre')
      ->where('t.username<>t.documento')
      ->orderBy(self::$_order_by_defa);
    return $DQL->execute();
  }


  public function setPassword(string $seed=null): bool
  {
    try 
    {
      $salt = md5(rand(100000, 999999).$this->username);
      if ( is_null($seed) )
      {
        $seed = ($this->documento == $this->username) ? $this->documento: substr($this->documento, -4);  // true:padres  false:empleados
      }
      return $this->update(
        [
          'salt' => $salt,
          'password' => hash('sha1', $salt.$seed),
        ]
      );
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
      return false;
    }
  }


  public function setRetirar(): bool 
  {    
    return $this->update(
      [
        'id' => $this->id,
        'fecha_ret' => date('Y-m-d', time()),
        'is_carga_acad_ok' => 0,
        'is_active' => 0,
      ]
    );
  }



}