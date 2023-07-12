<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait NotaTraitSetUp {
  
  use TraitUuid, TraitForms, NotaTraitProps, NotaTraitLinks;

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
   * CONFIGURACIÓN DEL MODELO
   *   'id', 'uuid', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 
  'asignatura', 'estudiante', 'email_envios', 'asi_num_envios', 
  'definitiva', 'plan_apoyo', 'nota_final', 'profesor_id', 
  'i01', 'i02', 'i03', 'i04', 'i05', 'i06', 'i07', 'i08', 'i09', 'i10', 
  'i11', 'i12', 'i13', 'i14', 'i15', 'i16', 'i17', 'i18', 'i19', 'i20', 
  'i21', 'i22', 'i23', 'i24', 'i25', 'i26', 'i27', 'i28', 'i29', 'i30', 
  'i31', 'i32', 'i33', 'i34', 'i35', 'i36', 'i37', 'i38', 'i39', 'i40', 
  'asi_desempeno', 'asi_activ_profe', 'asi_activ_estud', 'asi_fecha_entrega', 
  'asi_link_externo1', 'asi_link_externo2', 'paf_link_externo1', 'paf_link_externo2', 
  'paf_temas', 'paf_acciones', 'paf_activ_estud', 'paf_activ_profe', 'paf_fecha_entrega', 
  'is_paf_ok_coord', 'is_paf_validar_ok', 'is_paf_ok_dirgrupo', 'paf_num_envios', 
  'ausencias', 'inthoraria', 'created_at', 'updated_at', 'created_by', 'updated_by'
  'is_asi_validar_ok', 'asi_calificacion', 'is_asi_ok_dirgrupo', 'is_asi_ok_coord', 
   */

  private function setUp() {

    self::$_fields_show = [
      'all'     => ['id', 'uuid', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 
            'asignatura', 'estudiante', 'email_envios', 'asi_num_envios', 'definitiva', 'plan_apoyo', 'nota_final', 'profesor_id', 
            'i01', 'i02', 'i03', 'i04', 'i05', 'i06', 'i07', 'i08', 'i09', 'i10', 'i11', 'i12', 'i13', 'i14', 'i15', 'i16', 'i17', 'i18', 'i19', 'i20', 
            'i21', 'i22', 'i23', 'i24', 'i25', 'i26', 'i27', 'i28', 'i29', 'i30', 'i31', 'i32', 'i33', 'i34', 'i35', 'i36', 'i37', 'i38', 'i39', 'i40', 
            'asi_desempeno', 'asi_activ_profe', 'asi_activ_estud', 'asi_fecha_entrega', 'asi_link_externo1', 'asi_link_externo2', 'paf_link_externo1', 'paf_link_externo2', 
            'paf_temas', 'paf_acciones', 'paf_activ_estud', 'paf_activ_profe', 'paf_fecha_entrega', 
            'is_paf_ok_coord', 'is_paf_validar_ok', 'is_paf_ok_dirgrupo', 'paf_num_envios', 
            'is_asi_validar_ok', 'asi_calificacion', 'is_asi_ok_dirgrupo', 'is_asi_ok_coord',
            'ausencias', 'inthoraria', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'index'     => ['id', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 'i21', 'i22', 'i23', 'i24', 'i25' ],
      'create'    => ['periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 'i21', 'i22', 'i23', 'i24', 'i25' ],
      'edit'      => ['periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 'i21', 'i22', 'i23', 'i24', 'i25' ],
      'editUuis'  => ['periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 'i21', 'i22', 'i23', 'i24', 'i25' ],
      'calificar' => ['definitiva', 'plan_apoyo', 'nota_final', 'i01', 'i02', 'i03', 'i04', 'i05', 'i06', 'i07', 'i08', 'i09', 'i10', 'i11', 'i12', 'i13', 'i14', 'i15', 'i16', 'i17', 'i18', 'i19', 'i20'],
    ];
  
    self::$_widgets = [
      'definitiva'   => 'number',
      'plan_apoyo'   => 'number',
      'nota_final'   => 'number',

      'i01'   => 'number', 
      'i02'   => 'number', 
      'i03'   => 'number', 
      'i04'   => 'number', 
      'i05'   => 'number', 
      'i06'   => 'number', 
      'i07'   => 'number', 
      'i08'   => 'number', 
      'i09'   => 'number', 
      'i10'   => 'number', 
      'i11'   => 'number', 
      'i12'   => 'number', 
      'i13'   => 'number', 
      'i14'   => 'number', 
      'i15'   => 'number', 
      'i16'   => 'number', 
      'i17'   => 'number', 
      'i18'   => 'number', 
      'i19'   => 'number', 
      'i20'   => 'number', 
    ];

    self::$_attribs = [
      'id'       => 'required',
      'uuid'     => 'required', 

      'definitiva'   => ' min="0" max="100" ',
      'plan_apoyo'   => ' min="0" max="100" maxlength="3" size="3" ',
      'nota_final'   => ' min="0" max="100" maxlength="3" size="3" readonly',
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