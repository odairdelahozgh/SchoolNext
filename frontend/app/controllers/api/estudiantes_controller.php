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

   /**
    * Obtiene todos los registros de estudiantes
    * @link ../api/estudiantes/all
    */
   public function get_all() {
      $this->data = (new Estudiante)->getListActivos();
   }

   /**
    * Devuelve el estudiante buscado por UUID
    * @link ../api/estudiantes/singleuuid/3b22fefc7f6afa79c54f
    */
   public function get_singleuuid(string $uuid) {
      $record = (new Estudiante)->getByUUID($uuid);
      if (isset($record)) {
         $this->data = $record;
      } else {
         $this->error('El registro buscado no existe', 404);
      }
   }

   /**
    * Devuelve el estudiante buscado por ID
    * @link ../api/estudiantes/singleid/775
    */
    public function get_singleid(int $id) {
      $record = (new Estudiante)->getById($id);
      if (isset($record)) {
         $this->data = $record;
      } else {
         $this->error('El registro buscado no existe', 404);
      }
   }

}