<?php

require_once VENDOR_PATH.'autoload.php';
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
  }//END-info

  public function exportPdf() {
    View::template('pdf/mpdf');
    $this->pdf_fileName = OdaUtils::getSlug("listado-de-$this->controller_name");
    $this->pdf_title = "Listado de $this->controller_name";
    $this->data = (new $this->nombre_modelo())->getList(estado:1);
    $this->pdf_download = false;    
    View::select(view: "export_pdf_$this->controller_name", template: 'pdf/mpdf');
  }//END-exportPdf

  public function exportCsv() {
    $this->filename = OdaUtils::getSlug("listado-de-$this->controller_name");
    $this->data = (new $this->nombre_modelo())->getList(estado:1);
    View::select(null, "csv");
  }//END-exportCsv
  
  public function exportXml() {
    $this->filename = OdaUtils::getSlug("listado-de-$this->controller_name");
    $this->data = (new $this->nombre_modelo())->getList(estado:1);
    View::select(view: null, template: "xml");
  }//END-exportXml
  
  public function exportXls() {
    try {
      $config = ['path' => VENDOR_PATH.'viest'];
      OdaLog::debug(msg: VENDOR_PATH.'viest');
      $excel  = new \Vtiful\Kernel\Excel(config: $config);

      // fileName will automatically create a worksheet, 
      // you can customize the worksheet name, the worksheet name is optional
      $filePath = $excel->fileName(fileName: 'tutorial01.xlsx', sheetName: 'sheet1')
        ->header(header: ['Item', 'Cost'])
        ->data(data: [
            ['Rent', 1000],
            ['Gas',  100],
            ['Food', 300],
            ['Gym',  50],
        ])
      ->output();
    } catch (\Throwable $th) {
      OdaLog::debug(msg: $th->getMessage());
      throw $th;
    }
    
    
    View::select(view: null, template: null);
  }//END-exportXls



  public function exportXls2(): void { //EXCEL
    $this->Modelo = new $this->nombre_modelo();
    $this->filename = OdaUtils::getSlug(string: "listado-de-$this->controller_name");
    
    $registros = (new $this->nombre_modelo())->getList(estado:1);

    $this->header =[
      'Id'            =>'string',//text
      'Nombre Salón'  =>'string',//text
      'Grado'         =>'integer',
      '1'             =>  '',
      '2'             =>  '',
      '3'             =>  '',
      '4'             =>  '',
    ];

    foreach ($registros as $item) {
      $columnas = [];
      foreach ($this->Modelo->getFieldsShow(show: 'index') as $key => $col) {
        $columnas[] =  $item->$col;
      }
      $this->data[] = $columnas;
    }

    $writer = new XLSXWriter();
    $writer->writeSheetHeader(sheet_name: 'Sheet1', header_types: $this->header);
    //OdaUtils::ver_array($data);

    foreach($this->data as $row) {  
      $writer->writeSheetRow(sheet_name: 'Sheet1', row: $row);
    }
    //$writer->writeToFile( filename: $this->filename );
    View::select(view: null, template: null);
    //View::select(view: null, template: "xls");
  }//END-exportXls

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
      $redirect = "admin/$this->controller_name/create";

      if (Input::hasPost($this->nombre_post)) {
        if (!$this->Modelo->validar(Input::post($this->nombre_post))) {
          OdaFlash::error("$this->page_action. ".Session::get('error_validacion'), true);
          return Redirect::to($redirect);
        }
  
        if ($this->Modelo->create(Input::post($this->nombre_post))) {
          OdaFlash::valid($this->page_action);
          Input::delete();
          return Redirect::to();
        } else {
          OdaFlash::error("$this->page_action - No Creó el Registro.", true);
          $this->data = Input::post($this->nombre_post);
          return Redirect::to($redirect);
        }
      }

    } catch (\Throwable $th) {
      OdaFlash::error("$this->page_action - ".$th->getMessage(), true);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
      return Redirect::to($redirect);
    }

  }//END-create

   
  /**
   * admin/../create_ajax
   */
  public function create_ajax(string $redirect='') {
    $this->page_action = 'CREAR Registro ';
    $redirect = str_replace('.','/', $redirect);

    try {
      View::select(null, null);
      $Registro = new $this->nombre_modelo();

      if (!Input::hasPost($this->nombre_post)) {
        OdaFlash::error("$this->page_action - No coincide post [$this->nombre_post]", true);
        return Redirect::to($redirect);
      }

      if (!$Registro->validar(Input::post($this->nombre_post))) {
        OdaFlash::error("$this->page_action. ".Session::get('error_validacion'), true);
        return Redirect::to($redirect);
      }

      if ($Registro->create(Input::post($this->nombre_post))) {
        OdaFlash::valid("$this->page_action");
        Input::delete();
      } else {
        $this->data = Input::post($this->nombre_post);
        OdaFlash::error("$this->page_action - No Creó el Registro.", true);
      }
      return Redirect::to($redirect);

    } catch (\Throwable $th) {
      OdaFlash::error("$this->page_action - ".$th->getMessage(), true);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
      return Redirect::to($redirect);
    }

  }//END-create_ajax



  /**
   * admin/.../edit/{id}
   */
  public function edit(int $id) {
    $this->page_action = 'Editar Registro';

    try {
      $this->fieldsToShow = (new $this->nombre_modelo())::getFieldsShow(__FUNCTION__);
      $this->fieldsToHidden = (new $this->nombre_modelo())::getFieldsHidden(__FUNCTION__);
      $this->Modelo = (new $this->nombre_modelo())::get($id);

      $redirect = "admin/$this->controller_name/edit/$id";

      if (Input::hasPost($this->nombre_post)) {
        if ($this->Modelo->validar(Input::post($this->nombre_post))) {
          if ($this->Modelo->update(Input::post($this->nombre_post))) { // procede a guardar
            OdaFlash::valid("$this->page_action $id");
            return Redirect::to();
          }
          OdaFlash::error("$this->page_action. Guardar.", true);
          return Redirect::to($redirect);
        } else {
          OdaFlash::error("$this->page_action. ".Session::get('error_validacion'), true);
          return Redirect::to($redirect);
        }
      }

    } catch (\Throwable $th) {
      OdaFlash::error("$this->page_action - ".$th->getMessage(), true);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
      return Redirect::to();
    }
  }//END-edit



  /**
   * admin/.../editUuid/{$uuid}
   */
  public function editUuid(string $uuid) {
    $this->page_action = 'Editar Registro';

    try {
      $this->Modelo = (new $this->nombre_modelo())::getByUUID($uuid);
      $this->fieldsToShow = (new $this->nombre_modelo())::getFieldsShow(__FUNCTION__);
      $this->fieldsToHidden = (new $this->nombre_modelo())::getFieldsHidden(__FUNCTION__);

      if (Input::hasPost($this->nombre_post)) { // valida si hay datos a guardar
        if ( $this->Modelo->update(Input::post($this->nombre_post)) ) { // ´procede a guardar
          OdaFlash::valid("$this->page_action: $uuid");
          return Redirect::to();
        }
        OdaFlash::error($this->page_action, true);
        return Redirect::to();
      }
      View::select('edit');

    } catch (\Throwable $th) {
      OdaFlash::error("$this->page_action - ".$th->getMessage(), true);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
    }
  }//END-


  /**
   * admin/../edit_ajax
   */
  public function edit_ajax(int $id, string $redirect='') {
    $this->page_action = 'EDITAR Registro ';
    $redirect = str_replace('.','/', $redirect);

    try {
      View::select(null, null);
      $Registro = (new $this->nombre_modelo())::get($id);

      if (!Input::hasPost($this->nombre_post)) {
        OdaFlash::error("$this->page_action - No coincide post [$this->nombre_post]", true);
        return Redirect::to($redirect);
      }

      if (!$Registro->validar(Input::post($this->nombre_post))) {
        OdaFlash::error("$this->page_action. ".Session::get('error_validacion'), true);
        return Redirect::to($redirect);
      }

      if ( $Registro->update(Input::post($this->nombre_post)) ) {
        OdaFlash::valid($this->page_action);
      } else {
        $this->data = Input::post($this->nombre_post);
        OdaFlash::error("$this->page_action - No actualizó el Registro.", true);
      }
      return Redirect::to($redirect);

    } catch (\Throwable $th) {
      OdaFlash::error("$this->page_action - ".$th->getMessage(), true);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
      return Redirect::to($redirect);
    }

  }//END-edit_ajax


  /**
   * admin/.../del/{id}
   */
  public function del(int $id, string $redirect='') {
    $this->page_action = 'Eliminar Registro';
    $redirect = str_replace('.','/', $redirect);

    try {
      $Registro = new $this->nombre_modelo();
      if ( $Registro::delete($id) ) {
        OdaFlash::valid("$this->page_action: $id", true);
      } else {
        OdaFlash::error("$this->page_action: $id", true);
      }
      return Redirect::to($redirect);

    } catch (\Throwable $th) {
      OdaFlash::error("$this->page_action - ".$th->getMessage(), true);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
      return Redirect::to($redirect);
    }

  }//END-del


  /**
   * admin/.../delUuid/{uuid}/{redirect}
   */
  public function delUuid(string $uuid, string $redirect='') {
    $this->page_action = 'Eliminar Registro';
    $redirect = str_replace('.','/', $redirect);

    try {
      $Registro = new $this->nombre_modelo();
      if ( $Registro::deleteByUUID($uuid)) {
        OdaFlash::valid("$this->page_action: $uuid");
      } else {
        OdaFlash::error("$this->page_action: $uuid", true);
        return;
      }
      return Redirect::to($redirect);

    } catch (\Throwable $th) {
      OdaFlash::error("$this->page_action - ".$th->getMessage(), true);
      OdaLog::debug($th, __CLASS__.'-'.__FUNCTION__);
      return Redirect::to("$redirect");
    }
  }//END-delUuid

  /**
   * admin/.../ver/{id}
   */
  public function ver(int $id) {
    $this->data = (new $this->nombre_modelo())::get($id);
  }//END-ver


} //END-CLASS