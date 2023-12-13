<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait EstudianteAdjuntosTraitSetUp {
  
  use TraitUuid, TraitForms, EstudianteAdjuntosTraitProps, EstudianteAdjuntosTraitCorrecciones;
  
  public function validar($input_post) {
    Session::set('error_validacion', '');
    try{
      //validar::number()->length(1)->min(0)->max(1)->assert($input_post['is_active']);
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
      'all'     => ['id', 'uuid', 'estudiante_id', 'nombre_archivo1', 'coment_archivo1', 'estado_archivo1', 'nombre_archivo2', 'coment_archivo2', 'estado_archivo2', 'nombre_archivo3', 'coment_archivo3', 'estado_archivo3', 'nombre_archivo4', 'coment_archivo4', 'estado_archivo4', 'nombre_archivo5', 'coment_archivo5', 'estado_archivo5', 'nombre_archivo6', 'coment_archivo6', 'estado_archivo6', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'index'   => ['id', 'uuid', 'estudiante_id', 'estado_archivo1', 'estado_archivo2', 'estado_archivo3', 'estado_archivo4', 'estado_archivo5', 'estado_archivo6'],
      'create'  => ['estudiante_id', 'nombre_archivo1', 'coment_archivo1', 'estado_archivo1', 'nombre_archivo2', 'coment_archivo2', 'estado_archivo2', 'nombre_archivo3', 'coment_archivo3', 'estado_archivo3', 'nombre_archivo4', 'coment_archivo4', 'estado_archivo4', 'nombre_archivo5', 'coment_archivo5', 'estado_archivo5', 'nombre_archivo6', 'coment_archivo6', 'estado_archivo6'],
      'edit'    => ['id', 'estudiante_id', 'nombre_archivo1', 'coment_archivo1', 'estado_archivo1', 'nombre_archivo2', 'coment_archivo2', 'estado_archivo2', 'nombre_archivo3', 'coment_archivo3', 'estado_archivo3', 'nombre_archivo4', 'coment_archivo4', 'estado_archivo4', 'nombre_archivo5', 'coment_archivo5', 'estado_archivo5', 'nombre_archivo6', 'coment_archivo6', 'estado_archivo6']
    ];
  
    self::$_attribs = [
      'estudiante_id'       => 'required',
      //'nombre_archivo1'     => 'required',
      //'nombre_archivo2'     => 'required',
      //'nombre_archivo3'     => 'required',
      //'nombre_archivo4'     => 'required',
      //'nombre_archivo5'     => 'required',
      //'nombre_archivo6'     => 'required',
    ];
    
    self::$_defaults = [
    ];
  
    self::$_helps = [
      //'nombre_archivo1'  => 'Este archivo es obligatorio',
      //'nombre_archivo2'  => 'Este archivo es obligatorio',
      //'nombre_archivo3'  => 'Este archivo es obligatorio',
      //'nombre_archivo4'  => 'Este archivo es obligatorio',
      //'nombre_archivo5'  => '',
      'nombre_archivo6'  => 'Este archivo es obligatorio solo para los grados 9°, 10° y 11°',
    ];
  
    self::$_labels = [
      'nombre_archivo1'  => Config::get('matriculas.file_1_titulo'),
      'nombre_archivo2'  => Config::get('matriculas.file_2_titulo'),
      'nombre_archivo3'  => Config::get('matriculas.file_3_titulo'),
      'nombre_archivo4'  => Config::get('matriculas.file_4_titulo'),
      'nombre_archivo5'  => Config::get('matriculas.file_5_titulo'),
      'nombre_archivo6'  => Config::get('matriculas.file_6_titulo'),
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