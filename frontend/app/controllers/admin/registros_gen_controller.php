<?php
/**
  * Controlador RegistrosGen  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class RegistrosGenController extends AppController
{

  public function index() {
    Redirect::toAction('list');
  }
  
  public function list() {
    $this->page_action = 'Lista de Registros Observaciones Generales';
    $this->data = (new RegistrosGen)->getList();
  }

  /**
   * Crea un Registro
   */
  public function create() {
    $this->page_action = 'CREAR Registro';
    $RegistrosGen = new RegistrosGen();
    if (Input::hasPost('registrosgens')) {
      if ( $RegistrosGen->create(Input::post('registrosgens'))) {
        OdaFlash::valid('Operación exitosa :: Crear Registro');
        Input::delete();
        return Redirect::to();
      }
      OdaFlash::error('Falló Operación :: Crear Registro');
    }
  }
   
  
  /**
   * Crea un Registro con AJAX
   */
  public function create_ajax() {
    try {
      View::select(null, null);
      $this->page_action = 'CREAR Registro';
      $RegistrosGen = new RegistrosGen();
      if (Input::hasPost('registrosgens')) {
        if ( $RegistrosGen->create(Input::post('registrosgens'))) {
          OdaFlash::valid($this->page_action);
          $grado = Input::post('registrosgens.grado_id');
          $asignatura = Input::post('registrosgens.asignatura_id');
          Input::delete();
          return Redirect::to("docentes/docen-reg-observaciones");
        }
        OdaFlash::error($this->page_action);
      }
    } catch (\Throwable $th) {
      OdaLog::error($th);
    }
  } //END-create_ajax()


  /**
   * Edita un Registro
   */
  public function edit(int $id) {
    $this->page_action = 'Editar Registro';
    $RegistrosGen = new RegistrosGen();    
    if (Input::hasPost('registrosgen')) {
      if ($RegistrosGen->update(Input::post('registrosgen'))) {
        OdaFlash::valid("$this->page_action $RegistrosGen");
        return Redirect::to(); // al index del controller
      }
      OdaFlash::error('Editar Registro');
      return; // Redirect::to('?');
    }
    $this->Modelo = $RegistrosGen->get($id);
  }

  
  /**
   * Eliminar un registro
   */
  public function delUUID(string $uuid, string $redirect='') {
    $this->page_action = 'Eliminar Registro';
    $RegistrosGen = (new RegistrosGen)->getByUUID($uuid);
    if ($RegistrosGen::deleteById($RegistrosGen->id)) {
      OdaFlash::valid("$this->page_action: $RegistrosGen");
    } else {
      OdaFlash::error("$this->page_action: $RegistrosGen");
    }
    $redirect = str_replace('.','/', $redirect);
    return Redirect::to("$redirect");
  }

  public function delID(string $id, string $redirect='') {
    $this->page_action = 'Eliminar Registro';
    $RegistrosGen = (new RegistrosGen)->getById($id);
    if ($RegistrosGen::deleteById($id)) {
      OdaFlash::valid("$this->page_action: $RegistrosGen");
    } else {
      OdaFlash::error("$this->page_action: $RegistrosGen");
    }
    $redirect = str_replace('.','/', $redirect);
    return Redirect::to("$redirect");
  }


} // END CLASS
