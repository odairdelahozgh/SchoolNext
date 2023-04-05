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
  public function create_ajax(string $redirect='') {
    $this->page_action = 'CREAR Registro de Observaciones Generales';
    $redirect = 'docentes/registros_observaciones';

    try {
      View::select(null, null);
      $post_name = 'registrosgens';
      $Registro = new RegistrosGen();
      
      if (!Input::hasPost($post_name)) {
        OdaFlash::error("$this->page_action - No coincide post [$post_name]", true);
        return Redirect::to($redirect);
      }

      if (!$Registro->validar(Input::post($post_name))) {
        OdaFlash::error("$this->page_action. ".Session::get('error_validacion'), true);
        return Redirect::to($redirect);
      }

      if ($Registro->createWithPhoto(Input::post($post_name))) {
        OdaFlash::valid($this->page_action);
        Input::delete();
      } else {
        $this->data = Input::post($post_name);
        OdaFlash::error("$this->page_action - No Creó el Registro.", true);
      }
      return Redirect::to($redirect);

    } catch (\Throwable $th) {
      OdaFlash::error("$this->page_action - ".$th->getMessage(), true);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
      return Redirect::to($redirect);
    }

  } //END-create_ajax()

  
  /**
   * Actualiza un Registro con AJAX
   */
  public function edit_ajax(int $id, string $redirect='') {
    $this->page_action = 'EDITAR Registro de Observaciones Generales';
    $redirect = 'docentes/registros_observaciones';

    try {
      View::select(null, null);
      $post_name = 'registrosgens';
      $Registro = (new RegistrosGen)::get($id);

      if (!Input::hasPost($post_name)) {
        OdaFlash::error("$this->page_action - No coincide post [$post_name]", true);
        return Redirect::to($redirect);
      }

      if (!$Registro->validar(Input::post($post_name))) {
        OdaFlash::error("$this->page_action. ".Session::get('error_validacion'), true);
        return Redirect::to($redirect);
      }
      
      if ($Registro->saveWithPhoto(Input::post($post_name))) {
        OdaFlash::valid($this->page_action);
        Input::delete();
      } else {
        $this->data = Input::post($post_name);
        OdaFlash::error("$this->page_action - No actualizó el Registro.", true);
      }
      return Redirect::to($redirect);

    } catch (\Throwable $th) {
      OdaFlash::error("$this->page_action - ".$th->getMessage(), true);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
      return Redirect::to($redirect);
    }

  } //END-edit_ajax()
  
  
  
} // END CLASS
