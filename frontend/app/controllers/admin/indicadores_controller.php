<?php
/**
  * Controlador Indicadores  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class IndicadoresController extends ScaffoldController
{

  /**
   * Crea un Registro con AJAX
   */
  public function create_ajax() {
    try {
      View::select(null, null);
      $this->page_action = 'CREAR Registro';
      
      $Indicador = new $this->nombre_modelo();
      
      if (Input::hasPost($this->nombre_post)) {
        if ((new $this->nombre_modelo())->validar(Input::post($this->nombre_post))) {
          if ( $Indicador->create(Input::post($this->nombre_post))) {
            OdaFlash::valid("$this->page_action.");
            OdaLog::info("$this->page_action");
            //$grado = Input::post("$this->nombre_post.grado_id");
            //$asignatura = Input::post("$this->nombre_post.asignatura_id");
            //return Redirect::to("docentes/listIndicadores/$grado/$asignatura");
          } else {
            OdaFlash::error("$this->page_action. Falló operación guardar.");
            OdaLog::error("$this->page_action. Falló operación guardar.");
          }
        } else {
          OdaFlash::error("$this->page_action. ".Session::get('error_validacion'));
          OdaLog::error("$this->page_action. ".Session::get('error_validacion'));
        }
      }

    } catch (\Throwable $th) {
      OdaLog::error($th);
    }
  } //END-create_ajax()

  
} // END CLASS
