<?php

use Mpdf\Tag\Select;

/**
 * Modelo RegistrosGen * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */
 /* 
  id, uuid, tipo_reg, estudiante_id, annio, periodo_id, grado_id, salon_id, 
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
  } // END-getListProfesor

  
  public function saveWithPhoto($data)
  {
    $this->begin();
    if ($this->create($data)) {
      if ($this->updatePhoto($this->lastInsertId())) {
        $this->commit();
        return true;
      }
    }
    $this->rollback();
    return false;
  } //END-saveWithPhoto

  public function updatePhoto($id)
  {
    if ($foto_acudiente = $this->uploadPhoto('foto_acudiente')) { //Intenta subir la foto que viene en el campo 'foto_acudiente'
      $this->foto_acudiente = $foto_acudiente;
      Session::set('foto_acudiente',$foto_acudiente);
    }
    if ($foto_director = $this->uploadPhoto('foto_director')) { //Intenta subir la foto que viene en el campo 'foto_acudiente'
      $this->foto_director = $foto_director;
      Session::set('foto_director',$foto_director);
    }
    $reg = (new RegistrosGen)::get($id);
    $reg->save([
      'foto_acudiente' => $foto_acudiente,
      'foto_director'  => $foto_director,
    ]);
    return true;
  } //END-updatePhoto 

  public function uploadPhoto($imageField)  {
    $file = Upload::factory($imageField, 'file');
    $file->setExtensions(array('jpg', 'png', 'gif', 'jpeg'));
    if ($file->isUploaded()) {
      return $file->saveRandom('estud_reg_observ_gen');
    }
    return false;
  } //END-uploadPhoto

  
  
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