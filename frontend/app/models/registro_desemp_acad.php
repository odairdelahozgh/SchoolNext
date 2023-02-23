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

  public function saveWithPhoto($data)
  {
    $this->begin();
    if ($this->create($data)) {
      if ($this->updatePhoto()) {
        $this->commit();
        return true;
      }
    }
    $this->rollback();
    return false;
  } //END-saveWithPhoto

  public function updatePhoto()
  {
    if ($photo = $this->uploadPhoto('foto_acudiente')) { //Intenta subir la foto que viene en el campo 'foto_acudiente'
      $this->foto_acudiente = $photo; // Modifica el campo photo del usuario y lo intenta actualizar
      return $this->update();
    }
  } //END-updatePhoto

  public function uploadPhoto($imageField)
  {
    $file = Upload::factory($imageField, 'image'); // Usamos el adapter 'image'
    $file->setExtensions(array('jpg', 'png', 'gif', 'jpeg')); // le asignamos las extensiones a permitir
    if ($file->isUploaded()) { // Intenta subir el archivo
      return $file->saveRandom(); // Lo guarda usando un nombre de archivo aleatorio y lo retorna.
    }
    return false; //Si falla al subir
  } //END-uploadPhoto


} //END-CLASS