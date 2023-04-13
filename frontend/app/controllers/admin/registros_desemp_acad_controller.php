<?php
/**
  * Controlador RegistrosDesempAcad  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class RegistrosDesempAcadController extends ScaffoldController
{
 
  /**
   * Crea un Registro con AJAX
   */
  public function create_ajax(string $redirect='') {
    $this->page_action = 'CREAR Registro de Desempeño Académico';
    $redirect='docentes/registros_desemp_acad';

    try {
      View::select(view: null, template: null);

      $post_name = 'registrodesempacads';
      $Registro = new RegistroDesempAcad();
            
      if (!Input::hasPost(var: $post_name)) {
        OdaFlash::error(msg: "$this->page_action - No coincide post [$post_name]", audit: true);
        return Redirect::to(route: $redirect);
      }

      if (!$Registro->validar(input_post: Input::post(var: $post_name))) {
        OdaFlash::error(msg: "$this->page_action. ".Session::get(index: 'error_validacion'), audit: true);
        return Redirect::to(route: $redirect);
      }
      
      if ($Registro->createWithPhoto(data: Input::post(var: $post_name))) {
        OdaFlash::valid(msg: $this->page_action);
        Input::delete();
      } else {
        $this->data = Input::post(var: $post_name);
        OdaFlash::error(msg: "$this->page_action. No Creó el Registro.", audit: true);
      }
      return Redirect::to(route: $redirect);

    } catch (\Throwable $th) {
      OdaFlash::error(msg: $this->page_action, audit: true);
      OdaLog::debug(msg: $th, name_log: __CLASS__.'-'.__FUNCTION__);
    }
    
  } //END-create_ajax()

  
  /**
   * Actualiza un Registro con AJAX
   */
  public function edit_ajax(int $id, string $redirect='') {
    $this->page_action = 'EDITAR Registro de Desempeño Académico';
    $redirect='docentes/registros_desemp_acad';
    
    try {
      View::select(null, null);
      $post_name = 'registrodesempacads';
      $Registro = (new RegistroDesempAcad())::get($id);
      
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
      } else{
        $this->data = Input::post($post_name);
        OdaFlash::error("$this->page_action. Falló operación guardar.", true);
      }
      return Redirect::to($redirect);
      
    } catch (\Throwable $th) {
      OdaFlash::error($this->page_action, true);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
      return Redirect::to($redirect);
    }
  } //END-edit_ajax()
  
  

} // END CLASS
