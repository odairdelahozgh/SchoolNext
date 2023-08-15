<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

/**
 * 'id', 'extra', 'fecha_insc', 'estatus', 'is_active', 'is_trasladado', 'is_pago', 'nombres', 'apellido1', 'apellido2', 
 * 'documento', 'tipo_dcto', 'sexo', 'fecha_nac', 'pais_nac', 'depto_nac', 'ciudad_nac', 'direccion', 'barrio', 
 * 'telefono1', 'telefono2', 'grado_aspira', 'ante_instit', 'ante_instit_dir', 'ante_instit_tel', 'ante_grado', 
 * 'ante_fecha_ret', 'tiempoinstit', 'madre', 'madre_id', 'madre_prof', 'madre_empresa', 'madre_cargo', 'madre_tel_ofi', 
 * 'madre_tel_per', 'madre_email', 'madre_edad', 'padre', 'padre_id', 'padre_prof', 'padre_empresa', 'padre_cargo', 
 * 'padre_tel_ofi', 'padre_tel_per', 'padre_email', 'padre_edad', '1_colegio', '1_ciudad', '1_telefono', '1_grados', 
 * '1_annios', '1_motivo_ret', '2_colegio', '2_ciudad', '2_telefono', '2_grados', '2_annios', '2_motivo_ret', 
 * '3_colegio', '3_ciudad', '3_telefono', '3_grados', '3_annios', '3_motivo_ret', 'razones_cambio', 
 * 'observaciones', 'fecha_eval', 'fecha_entrev', 'result_matem', 'result_caste', 'result_ingle', 'result_socia', 
 * 'result_scien', 'result_pmate', 'result_plect', 'entrevista', 'recomendac', 'is_fecha_entrev', 'is_fecha_eval', 
 * 'ctrl_llamadas', 'created_by', 'created_at', 'updated_by', 'updated_at', 'is_habeas_data'
 */

trait AspiranteTraitSetUp {
  
  use TraitUuid, TraitForms;//, AspiranteTraitProps;

  public function validar($input_post) {
    try{
      Session::set('error_validacion', '');
      return true;
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-validar

  
  /**
   * CONFIGURACIÓN DEL MODELO
   */
  private function setUp() {
    self::$_fields_show = [
      'all'       => [''],
      'index'     => [''],
      'create'    => [''],
      'edit'      => [''],
      'editUuid'  => [''],
    ];
    
    self::$_widgets = [
      'is_active'   => 'select',
      'fecha_insc'  => 'date',
    ];

    self::$_attribs = [
      'nombres'      => 'required',
    ];
  
    self::$_defaults = [
      'is_active'   => 1,
    ];
  
    self::$_helps = [
      'is_active'    => 'Indica si est&aacute; activo el registro.',
    ];
  
    self::$_labels = [
      'nombres'          => 'Aspirante', 

      'is_active'       => 'Estado',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
      'nombres'          => 'Nombres del Aspirante', 
    ];
  
  } //END-SetUp
 
  
} //END-TRAIT