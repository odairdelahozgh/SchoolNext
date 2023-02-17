<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait EstudianteAdjuntosTraitSetUp {
  
  use TraitUuid, TraitForms, EstudianteAdjuntosTraitCorrecciones;
  
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
      'all'     => ['id', 'estudiante_id', 'nombre_archivo1', 'coment_archivo1', 'estado_archivo1', 'nombre_archivo2', 'coment_archivo2', 'estado_archivo2', 'nombre_archivo3', 'coment_archivo3', 'estado_archivo3', 'nombre_archivo4', 'coment_archivo4', 'estado_archivo4', 'nombre_archivo5', 'coment_archivo5', 'estado_archivo5', 'nombre_archivo6', 'coment_archivo6', 'estado_archivo6', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'index'   => ['id', 'estudiante_id', 'estado_archivo1', 'estado_archivo2', 'estado_archivo3', 'estado_archivo4', 'estado_archivo5', 'estado_archivo6'],
      'create'  => ['estudiante_id', 'nombre_archivo1', 'coment_archivo1', 'estado_archivo1', 'nombre_archivo2', 'coment_archivo2', 'estado_archivo2', 'nombre_archivo3', 'coment_archivo3', 'estado_archivo3', 'nombre_archivo4', 'coment_archivo4', 'estado_archivo4', 'nombre_archivo5', 'coment_archivo5', 'estado_archivo5', 'nombre_archivo6', 'coment_archivo6', 'estado_archivo6'],
      'edit'    => ['id', 'estudiante_id', 'nombre_archivo1', 'coment_archivo1', 'estado_archivo1', 'nombre_archivo2', 'coment_archivo2', 'estado_archivo2', 'nombre_archivo3', 'coment_archivo3', 'estado_archivo3', 'nombre_archivo4', 'coment_archivo4', 'estado_archivo4', 'nombre_archivo5', 'coment_archivo5', 'estado_archivo5', 'nombre_archivo6', 'coment_archivo6', 'estado_archivo6']
    ];
  
    self::$_attribs = [
      'estudiante_id'       => 'required',
      'nombre_archivo1'     => 'required',
      'nombre_archivo2'     => 'required',
      'nombre_archivo3'     => 'required',
      'nombre_archivo4'     => 'required',
      'nombre_archivo5'     => 'required',
    ];
    
    self::$_defaults = [
    ];
  
    self::$_helps = [
      'nombre_archivo1'  => 'Este archivo es obligatorio',
      'nombre_archivo2'  => 'Este archivo es obligatorio',
      'nombre_archivo3'  => 'Este archivo es obligatorio',
      'nombre_archivo4'  => 'Este archivo es obligatorio',
      'nombre_archivo5'  => 'Este archivo es obligatorio solo para los grados 9°, 10° y 11°',
      'nombre_archivo6'  => '',
    ];
  
    self::$_labels = [
      'nombre_archivo1'  => 'Recibo de Pago de Matrícula',
      'nombre_archivo2'  => 'Pagaré',
      'nombre_archivo3'  => 'Carta de Instrucciones del Pagaré',
      'nombre_archivo4'  => 'Formato de Consulta y Reporte en Centrales de Riesgo',
      'nombre_archivo5'  => 'Recibo de Pago del 50% del Curso PRE-ICFES',
      'nombre_archivo6'  => '',
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