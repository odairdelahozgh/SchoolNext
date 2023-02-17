<?php
/**
  * Controlador Areas  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class EstudiantesController extends ScaffoldController
{

  /**
   * admin/.../index
   */
  public function index() {
    $this->page_action = "Listado $this->controller_name" ;
    $this->data = (new $this->nombre_modelo())->getList();
    $this->fieldsToShow = (new $this->nombre_modelo())->getFieldsShow(__FUNCTION__);
    $this->fieldsToShowLabels = (new $this->nombre_modelo())->getFieldsShow(__FUNCTION__, true);
    $this->data = (new Estudiante)->getListEstudiantes(estado:1);
  }//END-list
  
  
} // END CLASS
