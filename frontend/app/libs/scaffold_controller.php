<?php

/**
 * Controlador base para la construcción de CRUD para modelos rápidamente
 *
 * @category Kumbia
 * @package Controller
 */
abstract class ScaffoldController extends AdminController
{
  public string $scaffold = 'schoolnext'; // en views/_shared/scaffolds/
  public string $model = ''; //Nombre del modelo en CamelCase
  
  public string $pdf_fileName = '';
  public string $pdf_title = '';
  public bool $pdf_download = false;
    
  public function info($view) {
    View::response($view);
  }

  public function exportPdf() {
    View::template('pdf/mpdf');
    $this->pdf_fileName = OdaUtils::getSlug("listado-de-$this->controller_name");
    $this->pdf_title = "Listado de $this->controller_name";
    $this->data = (new $this->nombre_modelo())->getList(estado:1);
    $this->pdf_download = false;    
    View::select("export_pdf_$this->controller_name", 'pdf/mpdf');
  }

  /**
   * admin/.../index
   */
  public function index() {
    $this->page_action = "Listado $this->controller_name" ;
    $this->data = (new $this->nombre_modelo())->getList();
    $this->fieldsToShow = (new $this->nombre_modelo())->getFieldsShow(__FUNCTION__);
    $this->fieldsToShowLabels = (new $this->nombre_modelo())->getFieldsShow(__FUNCTION__, true);
  }//END-list
  
  /**
   * admin/../create
   */
  public function create() {
    try {

      $this->page_action = 'CREAR Registro';
      $this->fieldsToShow = (new $this->nombre_modelo())::getFieldsShow(__FUNCTION__);
      $this->fieldsToHidden = (new $this->nombre_modelo())::getFieldsHidden(__FUNCTION__);
      $this->Modelo = new $this->nombre_modelo();
      if (Input::hasPost($this->nombre_post)) {
        if ((new $this->nombre_modelo())->validar(Input::post($this->nombre_post))) {
          if ( (new $this->nombre_modelo())->create(Input::post($this->nombre_post))) {
            OdaFlash::valid("$this->page_action");
            Input::delete();
            return Redirect::to();
          }
          OdaFlash::error("$this->page_action. Falló operación guardar.");
          return Redirect::to("admin/$this->controller_name/create");
        } else {
          OdaFlash::error("$this->page_action. ".Session::get('error_validacion'));
          return Redirect::to("admin/$this->controller_name/create");
        }
      }

    } catch (\Throwable $th) {
      OdaFlash::error($this->page_action);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
    }

  }//END-create

   
  /**
   * admin/.../edit/{id}
   */
  public function edit(int $id) {
    try {

      $this->page_action = 'Editar Registro';
      $this->fieldsToShow = (new $this->nombre_modelo())::getFieldsShow(__FUNCTION__);
      $this->fieldsToHidden = (new $this->nombre_modelo())::getFieldsHidden(__FUNCTION__);
      $this->Modelo = (new $this->nombre_modelo())::get($id);

      if (Input::hasPost($this->nombre_post)) {
        if ((new $this->nombre_modelo())->validar(Input::post($this->nombre_post))) {
          if ((new $this->nombre_modelo())->update(Input::post($this->nombre_post))) { // procede a guardar
            OdaFlash::valid("$this->page_action $id");
            return Redirect::to(); // regresa al listado
          }
          OdaFlash::error("$this->page_action. Guardar.");
          return Redirect::to("admin/$this->controller_name/edit/$id");
        } else {
          OdaFlash::error("$this->page_action. ".Session::get('error_validacion'));
          return Redirect::to("admin/$this->controller_name/edit/$id");
        }
      }

    } catch (\Throwable $th) {
      OdaFlash::error($this->page_action);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
    }
  }//END-edit



  /**
   * admin/.../editUuid/{$uuid}
   */
  public function editUuid(string $uuid) {
    try {

      $this->page_action = 'Editar Registro';
      if (Input::hasPost($this->nombre_post)) { // valida si hay datos a guardar
        if ( (new $this->nombre_modelo())->update(Input::post($this->nombre_post)) ) { // ´procede a guardar
          OdaFlash::valid("$this->page_action: $uuid");
          return Redirect::to();
        }
        OdaFlash::error($this->page_action);
        return; // Redirect::to();
      }
      $this->fieldsToShow = (new $this->nombre_modelo())::getFieldsShow(__FUNCTION__);
      $this->fieldsToHidden = (new $this->nombre_modelo())::getFieldsHidden(__FUNCTION__);
      $this->Modelo = (new $this->nombre_modelo())::getByUUID($uuid);
      View::select('edit');

    } catch (\Throwable $th) {
      OdaFlash::error($this->page_action);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
    }
  }//END-



  /**
   * admin/.../del/{id}
   */
  public function del(int $id, string $redirect='') {
    try {

      $this->page_action = 'Eliminar Registro';
      if ( (new $this->nombre_modelo())::delete($id)) {
        OdaFlash::valid("$this->page_action: $id");
      } else {
        OdaFlash::error("$this->page_action: $id");
        return;
      }
      $redirect = str_replace('.','/', $redirect);
      return Redirect::to("$redirect");

    } catch (\Throwable $th) {
      OdaFlash::error($this->page_action);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
    }
  }//END-del


  /**
   * admin/.../delUuid/{uuid}/{redirect}
   */
  public function delUuid(string $uuid, string $redirect='') {
    try {

      $this->page_action = 'Eliminar Registro';
      if ( (new $this->nombre_modelo())::deleteByUUID($uuid)) {
        OdaFlash::valid("$this->page_action: $uuid");
      } else {
        OdaFlash::error("$this->page_action: $uuid");
        return;
      }
      $redirect = str_replace('.','/', $redirect);
      return Redirect::to("$redirect");

    } catch (\Throwable $th) {
      OdaFlash::error($this->page_action);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
    }
  }//END-delUuid

  /**
   * admin/.../ver/{id}
   */
  public function ver(int $id) {
    $this->data = (new $this->nombre_modelo())::get($id);
  }//END-ver


} //END-CLASS