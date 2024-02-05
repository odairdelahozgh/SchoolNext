<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

include "estudiante/estudiante_padres_trait_set_up.php";

class EstudiantePadres extends LiteRecord 
{
  
  use EstudiantePadresTraitSetUp;
  
  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get(var: 'tablas.usuarios_estudiantes');
    $this->setUp();
  }

  
  public function getPadres(int $estudiante_id): array 
  {
    $DQL = new OdaDql(_from: __CLASS__);
    $DQL->select( 't.dm_user_id as id')
        ->where( 't.estudiante_id=?')->setParams(params: [$estudiante_id]);
    return $DQL->execute();
  }
  
  
  public function getHijos(int $padre_id): array 
  {
    $DQL = new OdaDql(_from: __CLASS__);
    $DQL->select('t.estudiante_id as id')
        ->where('t.dm_user_id=?')->setParams(params: [$padre_id]);
    return $DQL->execute();
  }
  

  
}