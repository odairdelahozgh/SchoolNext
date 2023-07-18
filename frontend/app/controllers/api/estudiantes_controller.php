<?php
/**
  * Controlador API ESTUDIANTES  
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * @example http://username:password@URL/api/estudiantes/all
  */
class EstudiantesController extends RestController
{
  public function get_all() {
    $this->data = (new Estudiante)->getListActivos();
  } //END-get_all
   

  public function get_singleuuid(string $uuid) {
    try {
      $record = (new Estudiante)->getByUUID($uuid);
      if (isset($record)) {
        $this->data = $record;
      } else {
        $this->error('El registro buscado no existe', 404);
      }
    
    } catch (\Throwable $th) {
      OdaLog::error($th);
      $this->error('EXCEPCION INTERNA CAPTURADA', 404);
    }
    
  } //END-get_singleuuid


    public function get_singleid(int $id) {
      try {
        $record = (new Estudiante)::get(pk: $id);
        if (isset($record)) {
          $this->data = $record;
        } else {
          $this->error('El registro buscado no existe', 404);
        }
        
      } catch (\Throwable $th) {
        OdaLog::error($th);
        $this->error('EXCEPCION INTERNA CAPTURADA', 404);
      }
   } //END-get_singleid


    public function get_info_contacto_padres() {
      try {
        $this->data = (new Estudiante)->getInfoContactoPadres(log: true);
        
      } catch (\Throwable $th) {
        OdaLog::error($th);
      }
   } //END-get_info_contacto_padres
   

}