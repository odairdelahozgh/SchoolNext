<?php
/**
 * @see Controller nuevo controller
 */
require_once CORE_PATH . 'kumbia/controller.php';

/**
 * Controlador principal que heredan los controladores
 *
 * Todos las controladores heredan de esta clase en un nivel superior
 * por lo tanto los métodos aquií definidos estan disponibles para
 * cualquier controlador.
 *
 * @category Kumbia
 * @package Controller
 */
abstract class AppController extends Controller
{
  public int  $_data_count = 0;
  public array  $arrData = [];
  public object $Modelo;
  public array  $fieldsToShow = [];
  public array  $fieldsToShowLabels = [];
  public array  $fieldsToHidden = [];
  public string $nombre_post   = '';
  public string $nombre_modelo = '';

  
	// ACL (Access Control List) permisos
	public $acl; //variable objeto ACL
	public $userRol = ""; //variable con el rol del usuario autenticado en la aplicación

  
  // PARA LA GENERACIÓN DE ARCHIVOS
  public $archivoPDF = null;
  public ?string $file_tipo = null;
  public ?string $file_name = null;
  public ?string $file_title = null;
  public bool $file_download = true;
  
  public $page_action = '';
  public $page_module = '';
  public $page_title  = 'Título Página';
  public $breadcrumb;

  public $theme     = 'dark';
  public $themei    = 'd';
  public $user_id   = 0;
  public $user_name   = '';
  public $id_instit   = '';

  final protected function initialize() {
    if (!Session::get('usuario_logged')) {
      Redirect::to("auth/login");
      return false;
    }

    
		//if(Auth::is_valid()) $this->userRol = Auth::get("rol");

    $this->breadcrumb = new Breadcrumb();
    $this->breadcrumb->class_ul = 'breadcrumb';
    //$this->breadcrumb->addCrumb(0, '&#127968;');
    $this->breadcrumb->addCrumb(0, '&#127968;', '');

    $this->user_id = Session::get('id');
    $this->user_name = Session::get('username');
    
    //$optTheme = (date("H",time())<18) ? 'light' : 'dark' ;
    $this->id_instit = Config::get('config.institution.id_name');
    $this->theme = (Session::get('theme')) ? Session::get('theme') : 'dark' ;
    $this->themei = substr($this->theme,0,1);

    $this->nombre_post   = strtolower(OdaUtils::pluralize($this->controller_name));
    $this->nombre_modelo = ucfirst(OdaUtils::singularize($this->controller_name));
  }
  
  final protected function finalize() {
    $this->page_action = (!$this->page_action) ? $this->action_name : $this->page_action;
    $this->page_title  = strtoupper($this->controller_name) .' - ' . $this->page_action .' | ' .APP_NAME;
  } //END-finalize



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
      OdaFlash::warning("$this->page_action Guardar");
      return Redirect::to("admin/$this->controller_name/create");
    } else {
      OdaFlash::warning("$this->page_action. ".Session::get('error_validacion'));
      return Redirect::to("admin/$this->controller_name/create");
    }
    }
  } catch (\Throwable $th) {
    OdaFlash::error($th);
  }
  }//END-create

   
  /**
   * admin/.../edit/{id}
   */
  public function edit(int $id) {
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
    OdaFlash::warning("$this->page_action Guardar");
    return Redirect::to("admin/$this->controller_name/edit/$id");
    } else {
    OdaFlash::warning("$this->page_action. ".Session::get('error_validacion'));
    return Redirect::to("admin/$this->controller_name/edit/$id");
    }
  }
  }//END-edit



  /**
   * admin/.../editUuid/{$uuid}
   */
  public function editUuid(string $uuid) {
  $this->page_action = 'Editar Registro';
  if (Input::hasPost($this->nombre_post)) { // valida si hay datos a guardar
    if ( (new $this->nombre_modelo())->update(Input::post($this->nombre_post)) ) { // ´procede a guardar
    OdaFlash::valid("$this->page_action: $uuid");
    return Redirect::to();
    }
    OdaFlash::warning($this->page_action);
    return; // Redirect::to();
  }
  $this->fieldsToShow = (new $this->nombre_modelo())::getFieldsShow(__FUNCTION__);
  $this->fieldsToHidden = (new $this->nombre_modelo())::getFieldsHidden(__FUNCTION__);
  $this->Modelo = (new $this->nombre_modelo())::getByUUID($uuid);
  View::select('edit');
  }//END-



  /**
   * admin/.../del/{id}
   */
  public function del(int $id, string $redirect='') {
  $this->page_action = 'Eliminar Registro';
  if ( (new $this->nombre_modelo())::delete($id)) {
    OdaFlash::valid("$this->page_action: $id");
  } else {
    OdaFlash::warning("$this->page_action: $id");
    return;
  }
  $redirect = str_replace('.','/', $redirect);
  return Redirect::to("$redirect");
  }//END-del


  /**
   * admin/.../delUuid/{uuid}/{redirect}
   */
  public function delUuid(string $uuid, string $redirect='') {
  $this->page_action = 'Eliminar Registro';
  if ( (new $this->nombre_modelo())::deleteByUUID($uuid)) {
    OdaFlash::valid("$this->page_action: $uuid");
  } else {
    OdaFlash::warning("$this->page_action: $uuid");
    return;
  }
  $redirect = str_replace('.','/', $redirect);
  return Redirect::to("$redirect");
  }//END-delUuid

  /**
   * admin/.../ver/{id}
   */
  public function ver(int $id) {
  $this->data = (new $this->nombre_modelo())::get($id);
  }//END-ver


} //END-CLASS
