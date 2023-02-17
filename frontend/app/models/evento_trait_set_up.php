<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait EventoTraitSetUp {
  
  use TraitUuid, TraitForms;
  
  public function __toString() { return "$this->id - $this->nombre"; }


  public function validar($input_post) {
    Session::set('error_validacion', '');
    try{
      validar::number()->length(1)->min(0)->max(1)->assert($input_post['is_active']);
      validar::date()->assert($input_post['fecha_desde']);
      if (strlen($input_post['fecha_hasta'])>0) {
        validar::date()->assert($input_post['fecha_hasta']);
      }
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
      'all'      => ['id', 'uuid', 'nombre', 'fecha_desde', 'fecha_hasta', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_active'],
      'index'    => ['is_active', 'nombre', 'fecha_desde', 'fecha_hasta'],
      'create'   => ['nombre', 'fecha_desde', 'fecha_hasta'],
      'edit'     => ['nombre', 'fecha_desde', 'fecha_hasta', 'is_active'],
      'editUuid' => ['nombre', 'fecha_desde', 'fecha_hasta', 'is_active'],
    ];
  
    self::$_attribs = [
      'nombre'       => 'required',
      'fecha_desde'  => 'required',

      'id'       => 'required',
      'uuid'     => 'required',
    ];
  
    self::$_defaults = [
      'is_active'       => 1,
    ];
  
    self::$_helps = [
      'is_active'    => 'Indica si está activo el registro.',
    ];
  
    self::$_labels = [
      'fecha_desde'=> 'Desde', 
      'fecha_hasta'=> 'Hasta',

      'id'              => 'ID',
      'uuid'            => 'UUID',
      'is_active'       => 'Está Activo? ',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
    ];
  
    // numeric, int, maxlength, length, range, select, email, url, ip, required, alphanum, alpha, date, pattern, decimal, equal
    self::$_rules_validators = [
        /*
        'NombreCompleto' => [
				  'required' => [ 'error' => 'Indique su nombre.' ],
				  'alpha'    => [ 'error' => 'Nombre incompleto o incorrecto.' ],
			  ],
			  'Email' => [
				  'required' => [ 'error' => 'Indique su email.' ],
				  'email'    => [ 'error' => 'Email incorrecto.' ],
			  ],
			  'Movil' => [
				  'required' => [ 'error' => 'Indique su teléfono / móvil.' ],
				  'length'   => [ 'min' => '9', 'max' => '17', 'error' => 'Teléfono / móvil incorrecto' ],
          'pattern'  => [ 'regexp' => '/^\+(?:[0-9] ?){6,14}[0-9]$/', 'error'  => 'Teléfono incorrecto. ejemplo. +34 862929929'],
        ], 
        */
    ];

  }
} //END-SetUp