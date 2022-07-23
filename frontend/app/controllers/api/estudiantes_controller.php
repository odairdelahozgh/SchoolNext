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
    * @link http://schoolnext.local.com/api/estudiantes/todos
    */
   public function get_todos() {
      $this->data = (new EstudianteApi())->all();
   }

   /**
    * Devuelve el estudiante buscado por UUID
    * @link http://schoolnext.local.com/api/estudiantes/uno/1848
    */
   public function get_uno($uuid) {
      $record = (new EstudianteApi())->get_uuid((int)$uuid);
      if (isset($record)) {
         $this->data = $record;
      } else {
         $this->error('El registro buscado no existe', 404);
      }
   }

}