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
      $RegistrosGen = new RegistrosGen();
      if (Input::hasPost('registrosgens')) {
        if ($RegistrosGen->validar(Input::post('registrosgens'))) {
          if ($RegistrosGen->create(Input::post('registrosgens'))) {
            OdaFlash::valid($this->page_action, true);
            Input::delete();
            return Redirect::to("docentes/registros_observaciones");
          }
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
   * Crea un Registro con AJAX
   */
  public function create_ajax2() {
    try {
      View::select(null, null);
      $this->page_action = 'CREAR Registro de Observaciones Generales';
      $RegistrosGen = new RegistrosGen();
      if (Input::hasPost('registrosgens')) {
        if ($RegistrosGen->validar(Input::post('registrosgens'))) {
          if ($RegistrosGen->saveWithPhoto(Input::post('registrosgens'))) {
            OdaFlash::valid($this->page_action, true);
            Input::delete();
            return Redirect::to("docentes/registros_observaciones");
          }
          $this->data = Input::post('registrosgens');
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

  } //END-create_ajax2()

  

  // public function edit_form_ajax(int $id) {
  //   try {
  //     View::select(null, null);
  //     $model = new RegistrosGen();
  //     $fieldsToHidden = $model::getFieldsHidden('edit');
    
  //     $myForm = new OdaForm($model, 'admin/registros_gen/edit_ajax', multipart: true);
  //     $myForm->setEdit();
  //     $myForm->setColumnas(2);
  //     $myForm->addSelect(field:'periodo_id', columna:1, data: OdaUtils::PERIODOS);
  //     $myForm->addInput(field:'fecha', columna:1, tipo:'date');
  //     $myForm->addInput(field:'acudiente', columna:1, tipo:'text');
  //     $myForm->addFile(field:'foto_acudiente', columna:1);
  //     $myForm->addInput(field:'director', columna:1, tipo:'text');
  //     $myForm->addFile(field:'foto_director', columna:1);  
  //     $myForm->addTextarea(field:'asunto', columna:2);
  //     $myForm->addHiddens(implode(",", $fieldsToHidden));
  //     return "<div id=\"edit_form_registros_gen\" class=\"w3-container\" id=\"formulario\">$myForm</div>";      
  //   } catch (\Throwable $th) {
  //     OdaFlash::error($this->page_action, true);
  //     OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
  //   }
  // }//END-edit_form_ajax
  
  
  
  
} // END CLASS
