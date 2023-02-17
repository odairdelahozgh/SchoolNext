<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait EstudianteAdjuntosDosTraitSetUp {
  
  use TraitUuid, TraitForms, EstudianteAdjuntosDosTraitCorrecciones;
  

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
      'all'     => ['id', 'estudiante_id', 'nombre_archivo1', 'coment_archivo1', 'estado_archivo1', 'nombre_archivo2', 'coment_archivo2', 'estado_archivo2', 'nombre_archivo3', 'coment_archivo3', 'estado_archivo3', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'index'    => ['id', 'estudiante_id', 'nombre_archivo1', 'nombre_archivo2', 'nombre_archivo3'],
      'create'  => ['estudiante_id', 'nombre_archivo1', 'coment_archivo1', 'estado_archivo1', 'nombre_archivo2', 'coment_archivo2', 'estado_archivo2', 'nombre_archivo3', 'coment_archivo3', 'estado_archivo3'],
      'edit'    => ['estudiante_id', 'nombre_archivo1', 'coment_archivo1', 'estado_archivo1', 'nombre_archivo2', 'coment_archivo2', 'estado_archivo2', 'nombre_archivo3', 'coment_archivo3', 'estado_archivo3']
    ];
  
    self::$_attribs = [
      'estudiante_id'   => 'required',
    ];
  
    self::$_defaults = [
    ];
  
    self::$_helps = [
      'nombre_archivo1'  => 'Este archivo es obligatorio',
      'nombre_archivo2'  => 'Este archivo es obligatorio'
    ];
  
    self::$_labels = [
      'nombre_archivo1'  => 'Contrato de Matr&iacute;cula',
      'nombre_archivo2'  => 'Libro de Matr&iacute;cula',
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