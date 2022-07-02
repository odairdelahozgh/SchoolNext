<?php
/**
  * Controlador Academico  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class EstudiantesController extends RestController
{
   /**
    * http://schoolnext.local.com/api/estudiantes/todos
    */
   public function get_todos() {
      $this->data = (new EstudianteApi())->all();
   }

   /**
    * http://schoolnext.local.com/api/estudiantes/uno/1848
    */
   public function get_uno($id) {
      $this->data = (new EstudianteApi())->getEstudiante( (int) $id);
   }

}