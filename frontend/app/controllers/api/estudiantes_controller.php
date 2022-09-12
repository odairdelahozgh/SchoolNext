<?php
/**
  * Controlador ESTUDIANTES  
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * 
  */
class EstudiantesController extends RestController
{

   /**
    * Obtiene todos los registros de estudiantes
    * @link http://username:password@schoolnext.local.com/api/estudiantes/all
    */
   public function get_all() {
      $this->data = (new ApiEstudiante())->all();
   }

   /**
    * Devuelve el estudiante buscado por UUID
    * @link http://username:password@schoolnext.local.com/api/estudiantes/singleuuid/3b22fefc7f6afa79c54f
    */
   public function get_singleuuid(string $uuid) {
      $record = (new ApiEstudiante())->get_uuid($uuid);
      if (isset($record)) {
         $this->data = $record;
      } else {
         $this->error('El registro buscado no existe', 404);
      }
   }

   /**
    * Devuelve el estudiante buscado por ID
    * @link http://username:password@schoolnext.local.com/api/estudiantes/singleid/775
    */
    public function get_singleid(int $id) {
      $record = (new ApiEstudiante())->get_id($id);
      if (isset($record)) {
         $this->data = $record;
      } else {
         $this->error('El registro buscado no existe', 404);
      }
   }

}