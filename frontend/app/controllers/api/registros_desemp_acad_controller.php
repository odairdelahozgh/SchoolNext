<?php
/**
  * Controlador API REGISTROS  
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * 
  */
class RegistrosDesempAcadController extends RestController
{

   /**
    * Obtiene todos los registros de estudiantes
    * @link /api/registros/all
    */
   public function get_all() {
      $this->data = (new RegistroDesempAcad)->all();
   }

   /**
    * Devuelve el estudiante buscado por UUID
    * @link /api/registros/singleuuid/3b22fefc7f6afa79c54f
    */
   public function get_singleuuid(string $uuid) {
    try {
      $record = (new RegistroDesempAcad())->getByUUID($uuid);
      if (isset($record)) {
         $this->data = $record;
      } else {
         $this->error('El registro buscado no existe', 404);
      }
    } catch (\Throwable $th) {
      OdaLog::debug($th, 'api_'.__CLASS__.'-'.__FUNCTION__);
    }
   }

   /**
    * Devuelve el estudiante buscado por ID
    * @link /api/registros_gen/singleid/{id}
    */
    public function get_singleid(int $id) {
      try {
        $record = (new RegistroDesempAcad())::get($id);
        if (isset($record)) {
          $this->data = $record;
        } else {
          $this->error('El registro buscado no existe', 404);
        }
      } catch (\Throwable $th) {
        OdaLog::debug($th, 'api_'.__CLASS__.'-'.__FUNCTION__);
      }
   }//END-get_singleid   

   
   public function get_reg_observ_annio_salon(int $annio, int $salon_id) {
    try {
      $result = (new RegistroDesempAcad())->getByAnnioSalon($annio, $salon_id);
      if (isset($result)) {
        $this->data = $result;
      } else {
        $this->error('No hay registros que coincidan con la busqueda', 404);
      }
    } catch (\Throwable $th) {
      OdaLog::debug($th, 'api_'.__CLASS__.'-'.__FUNCTION__);
    }
  } //END-get_reg_observ_annio
  

}//END-class