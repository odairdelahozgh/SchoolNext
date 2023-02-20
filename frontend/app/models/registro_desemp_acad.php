<?php
/**
 * Modelo RegistrosDesemp * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */
 
/* 
'id', 'uuid', 'estudiante_id', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'fortalezas', 'dificultades', 'compromisos', 'fecha', 'acudiente', 'foto_acudiente', 'director', 'foto_director', 'created_at', 'updated_at', 'created_by', 'updated_by'
*/
  
class RegistroDesempAcad extends LiteRecord {

  use RegistroDesempAcadTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.estud_reg_academ');
    self::$order_by_default = 't.estudiante_id, t.fecha DESC';
    $this->setUp();
  } //END-__construct

   
  // ===========
  public function getRegistrosProfesor(int $user_id) {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.*, s.nombre as salon_nombre')
        ->concat(concat:['e.nombres','e.apellido1','e.apellido2'], alias: 'estudiante_nombre')
        ->concat(concat:['u.nombres','u.apellido1','u.apellido2'], alias: 'usuario_nombre')
        ->leftJoin(table_singular:'estudiante', alias:'e')
        ->leftJoin(table_singular:'salon', alias:'s')
        ->leftJoin(table_singular:'usuario', alias:'u', condition:'t.created_by=u.id');
    if ($user_id<>1) {
      $DQL->where("t.created_by=?");
      $DQL->setParams([$user_id]);
    }
    $DQL->orderBy('t.fecha DESC');
    return $DQL->execute();
  }//END-getRegistrosProfesor


} //END-CLASS