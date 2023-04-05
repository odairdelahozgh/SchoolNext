<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait RangoTraitSetUp {
  
  use TraitUuid, TraitForms;
  
  public function validar($input_post): bool {
    Session::set(index: 'error_validacion', value: '');
    try{
      //validar::number()->length(1)->min(0)->max(1)->assert($input_post['is_active']);
      return true;
    } catch(NestedValidationException $exception) {
      Session::set(index: 'error_validacion', value: $exception->getFullMessage());
      return false;
    }
  } //END-validar

  /**
   * CONFIGURACIÓN DEL MODELO
   */
  private function setUp() {
    // 'id', 'nombre', 'lim_inf', 'lim_sup', 'color_rango', 'color_texto', 'color_backg', 
    // 'created_by', 'updated_by', 'created_at', 'updated_at'
    self::$_fields_show = [
      'all'     => ['id', 'nombre', 'lim_inf', 'lim_sup', 'color_rango', 'color_texto', 'color_backg', 'created_by', 'updated_by', 'created_at', 'updated_at'],
      'index'   => ['id', 'nombre', 'lim_inf', 'lim_sup', 'color_rango', 'color_texto', 'color_backg'],
      'create'  => ['nombre', 'lim_inf', 'lim_sup', 'color_rango', 'color_texto', 'color_backg'],
      'edit'    => ['nombre', 'lim_inf', 'lim_sup', 'color_rango', 'color_texto', 'color_backg'],
    ];
  
    self::$_attribs = [
      'id'      => 'required',
      'nombre'  => 'required',
      'lim_inf' => 'required',
      'lim_sup' => 'required',
    ];
  
    self::$_defaults = [
      'lim_inf'  => 0,
      'lim_sup'  => 0,
      'color_rango' => '',
      'color_texto' => '',
      'color_backg' => '',
    ];
  
    self::$_helps = [
      'color_rango' => 'nombre del color',
      'color_texto' => 'nombre del color',
      'color_backg' => 'nombre del color',
    ];
  
    self::$_labels = [
      'nombre'      => 'Nombre del Rango',
      'lim_inf'     => 'Límite Inferior',
      'lim_sup'     => 'Límite Superior',
      'color_rango' => 'Color del Rango',
      'color_texto' => 'Color de Texto',
      'color_backg' => 'Color de Fondo',

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