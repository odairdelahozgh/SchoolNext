<?php
/**
 * Modelo 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * id	estudiante_id	
 * nombre_archivo1	coment_archivo1	estado_archivo1	
 * nombre_archivo2	coment_archivo2	estado_archivo2	
 * nombre_archivo3	coment_archivo3	estado_archivo3	
 * nombre_archivo4	coment_archivo4	estado_archivo4	
 * nombre_archivo5	coment_archivo5	estado_archivo5	
 * nombre_archivo6	coment_archivo6	estado_archivo6	
 * created_at	updated_at	created_by	updated_by
 */
  
class EstudianteAdjuntos extends LiteRecord {

  use EstudianteAdjuntosTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.estud_adjuntos');
    $this->setUp();
  } //END-__construct

  
  public function saveWithAdjunto($data) {
    try {
      $this->begin();
      if ($this->update($data)) {
        if ($this->updateAdjunto($this->id)) {
          $this->commit();
          return true;
        }
      }
      $this->rollback();
      return false;
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-saveWithAdjunto



  public function updateAdjunto($id) {
    try {
      
      if ($nombre_archivo1 = $this->uploadAdjunto('nombre_archivo1')) { //Intenta subir la foto que viene en el campo 'foto_acudiente'
        $this->nombre_archivo1 = $nombre_archivo1;
        Session::set('nombre_archivo1',$nombre_archivo1);
      }

      $reg = (new EstudianteAdjuntos)::get($id);
      $reg->save([
        'nombre_archivo1' => $nombre_archivo1,
      ]);
      return true;
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-updateAdjunto 


  
  public function uploadAdjunto($field_type)  {
    try {
      $file = Upload::factory($field_type, 'file');
      $file->setExtensions(array('pdf','jpg', 'png', 'gif', 'jpeg'));
      if ($file->isUploaded()) {
        return $file->saveRandom('matriculas_adjuntos');
      }
      return false;
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-uploadAdjunto



} //END-CLASS