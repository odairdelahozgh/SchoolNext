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
      $this->page_action = 'CREAR Registro de Observaciones Generales';
      $post_name = 'registrosgens';
      $RegistrosGen = new RegistrosGen();
      if (Input::hasPost($post_name)) {
        if ($RegistrosGen->validar(Input::post($post_name))) {
          if ($RegistrosGen->createWithPhoto(Input::post($post_name))) {
            OdaFlash::valid($this->page_action, true);
            Input::delete();
            return Redirect::to("docentes/registros_observaciones");
          }
          $this->data = Input::post($post_name);
          OdaFlash::error("$this->page_action. Falló operación guardar.", true);
          return Redirect::to("docentes/registros_observaciones");
        } else {
          OdaFlash::error("$this->page_action. ".Session::get('error_validacion'), true);
          return Redirect::to("docentes/registros_observaciones");
        }
      }
      OdaFlash::error("$this->page_action. No coincide post.", true);
      return Redirect::to("docentes/registros_observaciones");
    } catch (\Throwable $th) {
      OdaFlash::error($this->page_action, true);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
    }

  } //END-create_ajax()

  
  /**
   * Actualiza un Registro con AJAX
   */
  public function edit_ajax(int $id) {
    try {
      View::select(null, null);
      $this->page_action = 'EDITAR Registro de Observaciones Generales';
      $post_name = 'registrosgens';
      $RegistrosGen = (new RegistrosGen())::get($id);
      if (Input::hasPost($post_name)) {
        if ($RegistrosGen->validar(Input::post($post_name))) {
          if ($RegistrosGen->saveWithPhoto(Input::post($post_name))) {
            OdaFlash::valid($this->page_action, true);
            Input::delete();
            return Redirect::to("docentes/registros_observaciones");
          }
          $this->data = Input::post($post_name);
          OdaFlash::error("$this->page_action. Falló operación guardar.", true);
          return Redirect::to("docentes/registros_observaciones");
        } else {
          OdaFlash::error("$this->page_action. ".Session::get('error_validacion'), true);
          return Redirect::to("docentes/registros_observaciones");
        }
      }
      OdaFlash::error("$this->page_action. No coincide post.", true);      
      return Redirect::to("docentes/registros_observaciones");
    } catch (\Throwable $th) {
      OdaFlash::error($this->page_action, true);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
    }

  } //END-edit_ajax()
  
  
  
} // END CLASS
