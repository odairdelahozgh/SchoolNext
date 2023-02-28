<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/


trait AsignaturaTraitSetUp {
  
  use TraitUuid, TraitForms;

  public function validar($input_post) {
    try{
      Session::set('error_validacion', '');
      /*
      if (!validar::digit()->length(1)->min(0)->max(1)->assert($input_post['is_active'])) {
        Session::set('error_validacion', 'Error evaluando '.self::$_labels['is_active']);
        return false;
      }
      if (!validar::digit()->assert($input_post['orden'])) {
        Session::set('error_validacion', 'Error evaluando '.self::$_labels['orden'].' ['.gettype($input_post['orden']).']');
        return false;
      }
      if (!validar::digit()->assert($input_post['area_id'])) {
        Session::set('error_validacion', 'Error evaluando '.self::$_labels['area_id']);
        return false;
      }
      if (!validar::alnum('á','é', 'í', 'ó', 'ú')->assert($input_post['nombre'])) {
        Session::set('error_validacion', 'Error evaluando '.self::$_labels['nombre']);
        return false;
      }
      if (!validar::alnum('á','é', 'í', 'ó', 'ú')->assert($input_post['abrev'])) {
        Session::set('error_validacion', 'Error evaluando '.self::$_labels['abrev']);
        return false;
      }
      */
      return true;
    } catch (\Throwable $th) {
      OdaFlash::error($th, true, 'Model:'.__CLASS__.'->'.__FUNCTION__.'() Line:'.__LINE__);
    }
  } //END-validar

  
  /**
   * CONFIGURACIÓN DEL MODELO
   */
  private function setUp() {
    // 'calc_prom' ??? se debe eliminar
    self::$_fields_show = [
      'all'       => ['id', 'nombre', 'abrev', 'orden', 'area_id', 'calc_prom', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_active'],
      'index'     => ['is_active', 'nombre', 'abrev', 'orden', 'area_id'],
      'create'    => ['nombre', 'abrev', 'orden', 'area_id'],
      'edit'      => ['nombre', 'abrev', 'orden', 'area_id', 'is_active'],
      'editUuid'  => ['nombre', 'abrev', 'orden', 'area_id', 'is_active'],
    ];
    
    self::$_widgets = [
      'is_active'   => 'select',
      'orden'       => 'number',
    ];

    self::$_attribs = [
      'nombre'      => 'required',
      'abrev'       => 'required',
      'area_id'     => 'required',
    ];
  
    self::$_defaults = [
      'is_active'   => 1,
      'orden'       => 0,
    ];
  
    self::$_helps = [
      'is_active'    => 'Indica si est&aacute; activo el registro.',
    ];
  
    self::$_labels = [
      'nombre'          => 'Asignatura', 
      'abrev'           => 'Abreviatura', 
      'orden'           => 'Orden de Listado', 
      'area_id'         => '&Aacute;rea',
      'is_active'       => 'Estado',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
    ];
  
  } //END-SetUp
 
  
} //END-TRAIT