<?php
/**
  * Controlador Cargas  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class CargasController extends AppController
{

  public function index() {
    Redirect::toAction('list');
  }
  
  public function list() {
    $this->page_action = 'Lista de Cargas';
    $this->data = (new SalAsigProf)->getList();
  }

  /**
   * Eliminar un registro
   */
  public function delUUID(string $uuid, string $redirect='') {
    $this->page_action = 'Eliminar Registro';
    $SalAsigProf = (new SalAsigProf)->getByUUID($uuid);
    if ($SalAsigProf::deleteById($SalAsigProf->id)) {
      OdaFlash::valid("$this->page_action: $SalAsigProf");
    } else {
      OdaFlash::error("$this->page_action: $SalAsigProf");
    }
    return Redirect::to("$redirect");
  }

  public function delID(string $id, string $redirect='') {
    $this->page_action = 'Eliminar Registro';
    $SalAsigProf = (new SalAsigProf)->getById($id);
    if ($SalAsigProf::deleteById($id)) {
      OdaFlash::valid("$this->page_action: $SalAsigProf");
    } else {
      OdaFlash::error("$this->page_action: $SalAsigProf");
    }
    return Redirect::to("$redirect");
  }


} // END CLASS
