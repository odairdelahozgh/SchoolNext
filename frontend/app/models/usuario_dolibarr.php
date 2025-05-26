<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

//include "usuario/usuario_trait_set_up.php";

#[AllowDynamicProperties]
class UsuarioDolibarr extends LiteRecord {

  //use UsuarioDolibarrTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = 'llx_users';
    self::$pk = 'rowid';
    //self::$_order_by_defa = '';
    //$this->setUp();
  }

  public function getUserGroups($user_id)
  {     
    $sql = "
    SELECT g.nom as group_name
    FROM llx_usergroup AS g
    WHERE g.rowid IN
      (SELECT gu.fk_usergroup
      FROM llx_usergroup_user AS gu
      WHERE gu.fk_user = ?)
    ";
    return static::query($sql, [$user_id])->fetch();
  }


}