<?php
/**
  * Controlador RegistrosGen  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class RegistrosGenController extends ScaffoldController
{

  
  /**
   * Crea un Registro con AJAX
   */
  public function create_ajax() {
    try {
      View::select(null, null);      
      //OdaLog::debug('mensaje', Input::post('registrosgens'));
      $this->page_action = 'CREAR Registro';
      $RegistrosGen = new RegistrosGen();
      if (Input::hasPost('registrosgens')) {
        if ( $RegistrosGen->create(Input::post('registrosgens'))) {
          OdaFlash::valid($this->page_action);
          Input::delete();
          return Redirect::to("docentes/registros_observaciones");
        }
        OdaFlash::error($this->page_action);
      }

    } catch (\Throwable $th) {
      OdaLog::debug($th, __CLASS__);
    }
  } //END-create_ajax()



} // END CLASS
