<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait AsignaturaTraitSetUp {
  
  use TraitUuid, TraitForms;

  public function validar($input_post) {
    Session::set('error_validacion', '');
    try{
      validar::number()->length(1)->min(0)->max(1)->assert($input_post['is_active']);
      
      // campos numéricos
      validar::number()->assert($input_post['orden']);
      validar::number()->assert($input_post['area_id']);

      // campos alfanumericos
      validar::alnum()->assert($input_post['nombre']);
      validar::alnum()->assert($input_post['abrev']);
      return true;
    } catch(NestedValidationException $exception) {
      Session::set('error_validacion', $exception->getFullMessage());
      return false;
    }
  } //END-validar

  
  /**
   * CONFIGURACIÓN DEL MODELO
   */
  private function setUp() {
    // 'calc_prom' ??? se debe eliminar
    self::$_fields_show = [
      'all'     => ['id', 'nombre', 'abrev', 'orden', 'area_id', 'calc_prom', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_active'],
      'index'   => ['is_active', 'nombre', 'abrev', 'orden', 'area_id'],
      'create'  => ['nombre', 'abrev', 'orden', 'area_id'],
      'edit'    => ['nombre', 'abrev', 'orden', 'area_id', 'is_active']
    ];
  
    self::$_attribs = [
      'nombre'      => 'required',
      'abrev'       => 'required',
      'area_id'     => 'required',
    ];
  
    self::$_defaults = [
      'is_active'       => 1,
    ];
  
    self::$_helps = [
      'is_active'    => 'Indica si est&aacute; activo el registro.',
    ];
  
    self::$_labels = [
      'nombre'          => 'Asignatura', 
      'abrev'           => 'Abreviatura', 
      'orden'           => 'Orden de Listado', 
      'area_id'         => '&Aacute;rea',
      'is_active'       => 'Est&aacute; Activo? ',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
    ];
  
    // numeric, int, maxlength, length, range, select, email, url, ip, required, alphanum, alpha, date, pattern, decimal, equal
    self::$_rules_validators = [
    ];

  } //END-SetUp
 
  
} //END-TRAIT