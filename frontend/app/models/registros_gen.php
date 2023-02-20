<?php

use Mpdf\Tag\Select;

/**
 * Modelo RegistrosGen * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */
 /* 
  id, uuid, estudiante_id, annio, periodo_id, grado_id, salon_id, 
  fecha, asunto, acudiente, foto_acudiente, director, foto_director, 
  created_at, updated_at, created_by, updated_by
*/
  
class RegistrosGen extends LiteRecord {

  use RegistrosGenTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.estud_reg_obs_gen');
    $this->setUp();
    self::$order_by_default = 't.annio, t.grado_id, t.estudiante_id, t.fecha DESC, ';
  } //END-__construct

  public static $periodos = [1=>'Periodo 1', 2=>'Periodo 2', 3=>'Periodo 3', 4=>'Periodo 4'];

 
  // ===========
  public function getRegistrosProfesor(int $user_id) {

    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.*, s.nombre as salon')
        ->concat(concat:['e.nombres','e.apellido1','e.apellido2'], alias: 'estudiante')
        ->concat(concat:['u.nombres','u.apellido1','u.apellido2'], alias: 'creador')
        ->leftJoin(table_singular:'estudiante', alias:'e')
        ->leftJoin(table_singular:'salon', alias:'s')
        ->leftJoin(table_singular:'usuario', alias:'u', condition:'t.created_by=u.id');
    if ($user_id<>1) {
      $DQL->where("t.created_by=?");
      $DQL->setParams([$user_id]);
    }
    $DQL->orderBy('t.fecha DESC');
    return $DQL->execute();

    /*
    $DQL = "SELECT rg.*, CONCAT(e.nombres,' ',e.apellido1,' ',e.apellido2) as estudiante,
            s.nombre as salon, CONCAT(u.nombres,' ',u.apellido1,' ',u.apellido2) as creador
            FROM ".self::$table." AS rg
            LEFT JOIN ".Config::get('tablas.estudiantes') ." as e ON rg.estudiante_id = e.id
            LEFT JOIN ".Config::get('tablas.salones') ." as s ON rg.salon_id      = s.id
            LEFT JOIN ".Config::get('tablas.usuarios')  ." as u ON rg.created_by    = u.id
            WHERE rg.created_by=$user_id
            ORDER BY rg.fecha desc";
    return $this::all($DQL);
    */
  } // END-getListProfesor

  // =============
  public function getRegistrosProfesorResumen($user_id) {
    $DQL = "SELECT s.nombre AS salon, COUNT(*) AS tot_reg
            FROM ".self::$table." AS rg
            LEFT JOIN ".Config::get('tablas.salones')." as s ON rg.salon_id=s.id
            WHERE rg.created_by=$user_id
            GROUP BY rg.salon_id;";
    return $this::all($DQL);
  } // END-getResumen

  
  // =============
  public function getRegistrosAnnio(int $annio) {
    $annio_actual = Config::get('config.academic.annio_actual');
    $sufijo = ($annio!=$annio_actual) ? '_'.$annio : '' ;

    $DQL = "SELECT rg.*, CONCAT(e.nombres,' ',e.apellido1,' ',e.apellido2) as estudiante,
            s.nombre as salon, CONCAT(u.nombres,' ',u.apellido1,' ',u.apellido2) as creador
            FROM ".self::$table.$sufijo." AS rg
            LEFT JOIN ".Config::get('tablas.estudiantes') ." as e ON rg.estudiante_id = e.id
            LEFT JOIN ".Config::get('tablas.salones') ." as s ON rg.salon_id      = s.id
            LEFT JOIN ".Config::get('tablas.usuarios')  ." as u ON rg.created_by    = u.id
            WHERE annio = $annio
            ORDER BY s.position,estudiante,rg.periodo_id";
    return $this::all($DQL);
  } // END-getRegistrosAnnio
    


} //END-CLASS