<?php
/**
  * Controlador API ESTUDIANTES  
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * 
  */
class NotasController extends RestController
{

   /**
    * Obtiene todos los registros de estudiantes
    * @link /api/notas/all
    */
   public function get_all() {
      $this->data = (new Nota)->all();
   }

   /**
    * Devuelve el registro de notas por UUID
    * @link /api/notas/singleuuid/3b22fefc7f6afa79c54f
    */
   public function get_singleuuid(string $uuid) {
      $record = (new Nota)->getByUUID($uuid);
      if (isset($record)) {
         $this->data = $record;
      } else {
         $this->error('El registro buscado no existe', 404);
      }
   }

   /**
    * Devuelve el registro de notas por ID
    * @link /api/notas/singleid/775
    */
    public function get_singleid(int $id) {
      $record = (new Nota)->getById($id);
      if (isset($record)) {
         $this->data = $record;
      } else {
         $this->error('El registro buscado no existe', 404);
      }
   }

  /**
   * Devuelve el registro de notas del presente año de un salon
   * @link /api/notas/notas_salon/1
   */
  public function get_notas_salon(int $salon_id) {
    $record = (new Nota)->getNotasConsolidado($salon_id);
    if (isset($record)) {
      $this->data = $record;
    } else {
      $this->error('El registro buscado no existe', 404);
    }
  }//END-get_notas_salon


  public function get_notasprom_periodo_salon(int $periodo_id, int $salon_id) {
    try {
      $record = (new Nota)->getNotasPromAnnioPeriodoSalon($periodo_id, $salon_id);
      if (isset($record)) {
        $this->data = $record;
      } else {
        $this->error('El registro buscado no existe', 404);
      }
    } catch (\Throwable $th) {
      OdaLog::debug($th, 'api_'.__CLASS__.'-'.__FUNCTION__);
    }
  }//END-get_notasprom_periodo_salon
  

}