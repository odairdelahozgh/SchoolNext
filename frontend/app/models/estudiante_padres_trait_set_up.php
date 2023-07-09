<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait EstudiantePadresTraitSetUp {
  
  use TraitUuid, TraitForms;
  
  public function validar($input_post) {
    Session::set('error_validacion', '');
    try{
      validar::number()->length(1)->min(0)->max(1)->assert($input_post['is_active']);
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
    self::$_fields_show = [
      'all'     => ['id', 'dm_user_id', 'estudiante_id', 'relacion', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'index'   => ['id', 'dm_user_id', 'estudiante_id', 'relacion', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'create'  => ['id', 'dm_user_id', 'estudiante_id', 'relacion', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'edit'    => ['id', 'dm_user_id', 'estudiante_id', 'relacion', 'created_at', 'updated_at', 'created_by', 'updated_by'],
    ];
  
    self::$_attribs = [
      'estudiante_id'       => 'required',
    ];
    
    self::$_defaults = [
    ];
  
    self::$_helps = [
    ];
  
    self::$_labels = [
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

  }
} //END-SetUp