<?php
/**
  * Controlador Salones  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class SalonesController extends AppController
{

  public function index() {
    Redirect::toAction('list');
    
  }
  
  public function list() {
    $this->page_action = 'Lista de Salones';
    //$this->breadcrumb->addCrumb(title: 'Salones');
    $this->data = (new Salon)->getList();
  }

  /**
   * Crea un Registro
   */
  public function create() {
    $this->page_action = 'CREAR Registro';
    
    $salon = new Salon();
    //$this->salones  = (new Salon)->getListActivos();

    if (Input::hasPost('salones')) {
      if ( $Salon->create(Input::post('salones'))) {
        OdaFlash::valid('Operación exitosa :: Crear Registro');
        Input::delete();
        return Redirect::to(); // al index del controller
      }
      OdaFlash::error('Falló Operación :: Crear Registro');
    }
  }
   
  /**
   * Edita un Registro
   *
   * @param int $id (requerido)
   */
  public function edit($id=0) {
    $this->page_action = 'Editar Registro';
    $Salon = new Salon();
    //$this->secciones = (new Seccion)->getListActivos('id, nombre');
    //$this->salones   = (new Salon)->getListActivos('id, nombre');
    //$this->grados  = (new Grado)->getListActivos('id, nombre');
    
    if (Input::hasPost('salones')) {
      if ($Salon->update(Input::post('salones'))) {
        OdaFlash::valid("$this->page_action $Salon");
        return Redirect::to(); // al index del controller
      }
      OdaFlash::error('Editar Registro');
      return; // Redirect::to('?');
    }
    $this->Modelo = $Salon->get((int) $id);
  }

  /**
   * Eliminar un registro
   *
   * @param int $uuid (requerido)
   */
  public function del(string $uuid) {
    $this->page_action = 'Eliminar Registro';
    $Grado = (new Grado)->getByUUID($uuid);
    if ($Grado::deleteById($Grado->id)) {
      OdaFlash::valid("$this->page_action: $Grado");
    } else {
      OdaFlash::error("$this->page_action: $Grado");
    }
    return Redirect::to();
  }

} // END CLASS
