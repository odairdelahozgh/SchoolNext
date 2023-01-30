<?php
/**
  * Controlador Indicadores  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class IndicadoresController extends AppController
{

  public function index() {
    Redirect::toAction('list');
  }
  
  public function list() {
    $this->page_action = 'Lista de Indicadores';
    //$this->breadcrumb->addCrumb(title: 'Indicadores');
    $this->data = (new Indicador)->getList();
  }

  /**
   * Crea un Registro
   */
  public function create() {
    $this->page_action = 'CREAR Registro';
    $Indicador = new Indicador();
    
    //$this->indicadores  = (new Indicador)->getListActivos();
    if (Input::hasPost('indicadors')) {
/*       $validador = new Validate(Input::post('indicadores.nombre'), $this->reglas() );
      if (!$validador->exec()) {
        $validador->flash();
        //OdaFlash::error('Falló Operación VALIDAR :: Crear Registro');
        return false;
      } */
      if ( $Indicador->create(Input::post('indicadors'))) {
        OdaFlash::valid('Operación exitosa :: Crear Registro');
        Input::delete();
        return Redirect::to(); // al index del controller
      }
      OdaFlash::error('Falló Operación :: Crear Registro');
    }
  }
   
  
  /**
   * Crea un Registro
   */
  public function create_ajax($grado, $asignatura) {
    View::select(null, null);
    $this->page_action = 'CREAR Registro';
    $Indicador = new Indicador();
    if (Input::hasPost('indicadors')) {
      if ( $Indicador->create(Input::post('indicadors'))) {
        OdaFlash::valid('Operación exitosa :: Crear Registro');
        //$grado = Input::get('grado_id');
        //$asignatura = Input::get('asignatura_id');
        Input::delete();
        //return Redirect::to("docentes/listIndicadores/$grado/$asignatura");
      }
      OdaFlash::error('Falló Operación :: Crear Registro');
    }
    return 0;
  }


  /**
   * Edita un Registro
   *
   * @param int $id (requerido)
   */
  public function edit($id=0) {
    $this->page_action = 'Editar Registro';
    $Indicador = new Indicador();    
    if (Input::hasPost('indicadores')) {
      if ($Indicador->update(Input::post('indicadores'))) {
        OdaFlash::valid("$this->page_action $Indicador");
        return Redirect::to(); // al index del controller
      }
      OdaFlash::error('Editar Registro');
      return; // Redirect::to('?');
    }
    $this->Modelo = $Indicador->get((int) $id);
  }

  /**
   * Eliminar un registro
   *
   * @param int $uuid (requerido)
   */
  public function del(string $uuid) {
    $this->page_action = 'Eliminar Registro';
    $Indicador = (new Indicador)->getByUUID($uuid);
    if ($Indicador::deleteById($Indicador->id)) {
      OdaFlash::valid("$this->page_action: $Indicador");
    } else {
      OdaFlash::error("$this->page_action: $Indicador");
    }
    return Redirect::to();
  }

} // END CLASS
