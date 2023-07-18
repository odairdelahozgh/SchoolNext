<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait PlanesapoyoTraitSetUp {
  
  use TraitUuid, TraitForms;
  
  public function validar($input_post): bool {
    Session::set(index: 'error_validacion', value: '');
    try{
      return true;
    } catch(NestedValidationException $exception) {
      Session::set(index: 'error_validacion', value: $exception->getFullMessage());
      return false;
    }
  } //END-validar

  
 /* 
  'id', 'uuid', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 
  'definitiva', 'plan_apoyo', 'nota_final', 'profesor_id', 
  
  /// planes de apoyo
  'i31', 'i32', 'i33', 'i34', 'i35', 'i36', 'i37', 'i38', 'i39', 'i40', 

  'paf_link_externo1', 'paf_link_externo2', 
  'paf_temas', 'paf_acciones', 'paf_activ_estud', 
  'paf_activ_profe', 'paf_fecha_entrega', 
  'is_paf_ok_coord', 'is_paf_validar_ok', 'is_paf_ok_dirgrupo', 
  
  'created_at', 'updated_at', 'created_by', 'updated_by'
*/

  private function setUp() {

    self::$_fields_show = [
      'all' => ['id', 'uuid', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 
            'definitiva', 'plan_apoyo', 'nota_final', 'profesor_id', 
            'i30', 'i31', 'i32', 'i33', 'i34', 'i35', 'i36', 'i37', 'i38', 'i39', 'i40', 
            'paf_link_externo1', 'paf_link_externo2', 'paf_temas', 'paf_acciones', 'paf_activ_estud', 'paf_activ_profe', 
            'paf_fecha_entrega', 'is_paf_ok_coord', 'is_paf_validar_ok', 'is_paf_ok_dirgrupo', 
            'created_at', 'updated_at', 'created_by', 'updated_by'],
      'index'     => ['id', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 'i30', 'i31', 'i32', 'i33', 'i34', 'i35' ],
      'create'    => ['periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 'i30', 'i31', 'i32', 'i33', 'i34', 'i35', 'i36', 'i37', 'i38', 'i39', 'i40' ],
      'edit'      => ['periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 'i30', 'i31', 'i32', 'i33', 'i34', 'i35', 'i36', 'i37', 'i38', 'i39', 'i40' ],
      'editUuid'  => ['periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 'i30', 'i31', 'i32', 'i33', 'i34', 'i35', 'i36', 'i37', 'i38', 'i39', 'i40' ],
      'calificar' => ['definitiva', 'plan_apoyo', 'nota_final', 'i30', 'i31', 'i32', 'i33', 'i34', 'i35', 'i36', 'i37', 'i38', 'i39', 'i40'],
    ];
  
    self::$_widgets = [
      'definitiva'   => 'number',
      'plan_apoyo'   => 'number',
      'nota_final'   => 'number', 
      
      'i31'   => 'number', 
      'i32'   => 'number', 
      'i33'   => 'number', 
      'i34'   => 'number', 
      'i35'   => 'number', 
      'i36'   => 'number', 
      'i37'   => 'number', 
      'i38'   => 'number', 
      'i39'   => 'number', 
      'i40'   => 'number', 
    ];

    self::$_attribs = [
      'id'       => 'required',
      'uuid'     => 'required', 

      'definitiva'   => ' min="0" max="100" maxlength="3" size="3" ',
      'plan_apoyo'   => ' min="0" max="100" maxlength="3" size="3" ',
      'nota_final'   => ' min="0" max="100" maxlength="3" size="3" ',
      
      'i31'   => ' maxlength="4" size="4" ',
      'i32'   => ' maxlength="4" size="4" ',
      'i33'   => ' maxlength="4" size="4" ',
      'i34'   => ' maxlength="4" size="4" ',
      'i35'   => ' maxlength="4" size="4" ',
      'i36'   => ' maxlength="4" size="4" ',
      'i37'   => ' maxlength="4" size="4" ',
      'i38'   => ' maxlength="4" size="4" ',
      'i39'   => ' maxlength="4" size="4" ',
      'i40'   => ' maxlength="4" size="4" ',
    ];
  
    self::$_defaults = [
      'is_active'       => 1,
    ];
  
    self::$_helps = [
      'is_active'    => 'Indica si está activo el registro.',
    ];
  
    self::$_labels = [
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