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
      $this->page_action = 'CREAR Registro de Observaciones Generales';
      $post_name = 'registrosgens';
      $RegistrosGen = new RegistrosGen();
      if (Input::hasPost($post_name)) {
        if ($RegistrosGen->validar(Input::post($post_name))) {
          if ($RegistrosGen->createWithPhoto(Input::post($post_name))) {
            OdaFlash::valid($this->page_action, true);
            Input::delete();
            return Redirect::to("docentes/listIndicadores");
          }
          $this->data = Input::post($post_name);
          OdaFlash::error("$this->page_action. Falló operación guardar.", true);
          return Redirect::to("docentes/listIndicadores");
        } else {
          OdaFlash::error("$this->page_action. ".Session::get('error_validacion'), true);
          return Redirect::to("docentes/listIndicadores");
        }
      }
      OdaFlash::error("$this->page_action. No coincide post.", true);
      return Redirect::to("docentes/listIndicadores");
    } catch (\Throwable $th) {
      OdaFlash::error($this->page_action, true);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
    }

  } //END-create_ajax()

  
} // END CLASS
