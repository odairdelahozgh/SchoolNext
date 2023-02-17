<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait IndicadorTraitSetUp {
  
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
      'all'     => ['id', 'uuid', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_active'],
      'index'   => ['is_active', 'concepto', 'created_at', 'updated_at'],
      'create'  => ['id', 'uuid', ],
      'edit'    => ['id', 'uuid',  'is_active']
    ];
  
    self::$_attribs = [
      'id'          => 'required',
      'uuid'        => 'required',
      'codigo'      => 'required',
      'concepto'    => 'required',
    ];
  
    self::$_defaults = [
      'is_active'       => 1,
    ];
  
    self::$_helps = [
      'codigo'       => 'Min: 100 - Max: 399 [Excepto Inglés]',
      'is_active'    => 'Indica si está activo el registro.',
    ];
  
    self::$_labels = [
      'annio'           => 'Año',
      'periodo_id'      => 'Periodo',
      'grado_id'        => 'Grado',
      'asignatura_id'   => 'Asignatura',
      'codigo'          => 'Código',
      'concepto'        => 'Concepto',
      'valorativo'      => 'Valorativo',
      'is_visible'      => 'Visible en Calificar?',

      'is_active'       => 'Está Activo? ',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
      'codigo'     => 'Fort:100-199 - Debil:200-299 - Recom:300-399',
    ];
  
    // numeric, int, maxlength, length, range, select, email, url, ip, required, alphanum, alpha, date, pattern, decimal, equal
    self::$_rules_validators = [
        /*
        'NombreCompleto' => [
				  'required' => [ 'error' => 'Indique su nombre.' ],
				  'alpha'    => [ 'error' => 'Nombre incompleto o incorrecto.' ]
			  ],
			  'Email' => [
				  'required' => [ 'error' => 'Indique su email.' ],
				  'email'    => [ 'error' => 'Email incorrecto.' ]
			  ],
			  'Movil' => [
				  'required' => [ 'error' => 'Indique su teléfono / móvil.' ],
				  'length'   => [ 'min' => '9', 'max' => '17', 'error' => 'Teléfono / móvil incorrecto' ],
          'pattern'  => [ 'regexp' => '/^\+(?:[0-9] ?){6,14}[0-9]$/', 'error'  => 'Teléfono incorrecto. ejemplo. +34 862929929']
        ], 
        */
    ];

  }
} //END-SetUp