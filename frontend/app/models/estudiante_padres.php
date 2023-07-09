<?php
/**
 * Modelo EstudiantePadres
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * id, dm_user_id, estudiante_id, relacion, created_at, updated_at, created_by, updated_by FROM sweb_dmuser_estudiantes
 */
  
class EstudiantePadres extends LiteRecord {
  
  use EstudiantePadresTraitSetUp;
  
  public function __construct() {
    parent::__construct();
    self::$table = Config::get(var: 'tablas.usuarios_estudiantes');
    $this->setUp();
  } //END-__construct
  
  public function getPadres(int $estudiante_id): array {
    $DQL = new OdaDql(_from: __CLASS__);
    $DQL->select( 't.dm_user_id as id')
        ->where( 't.estudiante_id=?')->setParams(params: [$estudiante_id]);
    return $DQL->execute(write_log: true);
  } //END-getPadres
  
  public function getHijos(int $padre_id): array {
    $DQL = new OdaDql(_from: __CLASS__);
    $DQL->select('t.estudiante_id as id')
        ->where('t.dm_user_id=?')->setParams(params: [$padre_id]);
    return $DQL->execute(write_log: true);
  } //END-getHijos
  
  
} //END-CLASS