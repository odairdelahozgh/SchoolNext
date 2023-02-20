<?php
/**
  * Controlador RegistrosGen  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class RegistrosDesempAcadController extends ScaffoldController
{

  
  /**
   * Crea un Registro con AJAX
   */
  public function create_ajax() {
    try {
      View::select(null, null);
      $this->page_action = 'CREAR Registro de Desempeño Académico';
      $RegistroDesempAcad = new RegistroDesempAcad();
      if (Input::hasPost('registrodesempacads')) {
        if ($RegistroDesempAcad->validar(Input::post('registrodesempacads'))) {
          if ($RegistroDesempAcad->create(Input::post('registrodesempacads'))) {
            OdaFlash::valid($this->page_action, true);
            Input::delete();
            return Redirect::to("docentes/registros_desemp_acad");
          }
          OdaFlash::error("$this->page_action. Falló operación guardar.", true);
          return Redirect::to("docentes/registros_desemp_acad");
        } else {
          OdaFlash::error("$this->page_action. ".Session::get('error_validacion'), true);
          return Redirect::to("docentes/registros_desemp_acad");
        }
      }
      OdaFlash::error("$this->page_action. No coincide post.", true);      
      return Redirect::to("docentes/registros_desemp_acad");

    } catch (\Throwable $th) {
      OdaFlash::error($this->page_action, true);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
    }

  } //END-create_ajax()



} // END CLASS
