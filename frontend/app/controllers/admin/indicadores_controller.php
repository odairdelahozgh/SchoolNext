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
/*       $validador = new Validate(Input::post('indicadors.nombre'), $this->reglas() );
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
   * Crea un Registro con AJAX
   */
  public function create_ajax() {
    $emailValidator = \Respect\Validation\Validator::email();
    /*
        try{
           $emailValidator->assert($request->get('email'));
       }
       catch(\Respect\Validation\Exceptions\NestedValidationExceptionInterface $ex){
           $errors = $ex->getMainMessage();
           // redirect with errors
       }
 */
    try {
      View::select(null, null);
      $this->page_action = 'CREAR Registro';
      $Indicador = new Indicador();
      if (Input::hasPost('indicadors')) {
        if ( $Indicador->create(Input::post('indicadors'))) {
          OdaFlash::valid($this->page_action);
          $grado = Input::post('indicadors.grado_id');
          $asignatura = Input::post('indicadors.asignatura_id');
          Input::delete();
          return Redirect::to("docentes/listIndicadores/$grado/$asignatura");
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
    $Indicador = new Indicador();    
    if (Input::hasPost('indicadores')) {
      if ($Indicador->update(Input::post('indicadores'))) {
        OdaFlash::valid("$this->page_action $Indicador");
        return Redirect::to(); // al index del controller
      }
      OdaFlash::error('Editar Registro');
      return; // Redirect::to('?');
    }
    $this->Modelo = $Indicador->get($id);
  }

  /**
   * Eliminar un registro
   */
  public function del(int $id) {
    $this->page_action = 'Eliminar Registro';
    $Indicador = (new Indicador)->getById($id);
    if ($Indicador::deleteById($Indicador->id)) {
      OdaFlash::valid("$this->page_action: $Indicador");
    } else {
      OdaFlash::error("$this->page_action: $Indicador");
    }
    return Redirect::to();
  }

  
  /**
   * Eliminar un registro
   */
  public function delUUID(string $uuid) {
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
