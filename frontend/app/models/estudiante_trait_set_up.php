<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait EstudianteTraitSetUp {
  
  use TraitUuid, TraitForms, EstudianteTraitProps, EstudianteTraitLinks;
  
  public function validar($input_post) {
    Session::set('error_validacion', '');
    try{
      validar::number()->length(1)->min(0)->max(1)->assert($input_post['is_active']);
      //validar::number()->length(1)->min(0)->max(1)->assert($input_post['is_debe_preicfes']);
      //validar::number()->length(1)->min(0)->max(1)->assert($input_post['is_debe_almuerzos']);
      
      // campos numéricos
      //validar::number()->assert($input_post['mes_pagado']);

      // campos alfabeticos
      //validar::alnum()->assert($input_post['nombres']);
      //validar::alnum()->assert($input_post['apellido1']);
      
      validar::date()->assert($input_post['fecha_nac']);
      // campos alfanumericos
      
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
      'all'      => ['id', 'uuid', 'is_active', 'mes_pagado', 'is_debe_preicfes', 'is_debe_almuerzos', 'is_deudor', 'is_habilitar_mat', 'salon_id', 'grado_mat', 'numero_mat', 'annio_promovido', 'documento', 'contabilidad_id', 'nombres', 'apellido1', 'apellido2', 'fecha_nac', 'direccion', 'barrio', 'telefono1', 'telefono2', 'email', 'created_at', 'updated_at', 'created_by', 'updated_by', 'tipo_dcto', 'sexo', 'photo', 'ape1ape1', 'retiro', 'fecha_ret', 'mat_bajo_p1', 'mat_bajo_p2', 'mat_bajo_p3', 'mat_bajo_p4', 'email_instit', 'clave_instit', 'annio_pagado'],
      'index'    => ['is_active', 'nombre', 'salon_id', 'documento', 'email_instit', 'clave_instit'],
      'create'   => ['nombres', 'apellido1', 'apellido2', 'mes_pagado', 'is_debe_preicfes', 'is_debe_almuerzos', 'is_deudor', 'is_habilitar_mat', 'salon_id', 'grado_mat', 'numero_mat', 'annio_promovido', 'documento', 'contabilidad_id', 'fecha_nac', 'direccion', 'barrio', 'telefono1', 'telefono2', 'email', 'tipo_dcto', 'sexo', 'photo', 'ape1ape1', 'retiro', 'fecha_ret', 'mat_bajo_p1', 'mat_bajo_p2', 'mat_bajo_p3', 'mat_bajo_p4', 'email_instit', 'clave_instit', 'annio_pagado'],
      'edit'     => ['nombres', 'apellido1', 'apellido2', 'is_active', 'mes_pagado', 'is_debe_preicfes', 'is_debe_almuerzos', 'is_deudor', 'is_habilitar_mat', 'salon_id', 'grado_mat', 'numero_mat', 'annio_promovido', 'documento', 'contabilidad_id', 'fecha_nac', 'direccion', 'barrio', 'telefono1', 'telefono2', 'email', 'tipo_dcto', 'sexo', 'photo', 'ape1ape1', 'retiro', 'fecha_ret', 'mat_bajo_p1', 'mat_bajo_p2', 'mat_bajo_p3', 'mat_bajo_p4', 'email_instit', 'clave_instit', 'annio_pagado'],
      'editUuid' => ['nombres', 'apellido1', 'apellido2', 'is_active', 'mes_pagado', 'is_debe_preicfes', 'is_debe_almuerzos', 'is_deudor', 'is_habilitar_mat', 'salon_id', 'grado_mat', 'numero_mat', 'annio_promovido', 'documento', 'contabilidad_id', 'fecha_nac', 'direccion', 'barrio', 'telefono1', 'telefono2', 'email', 'tipo_dcto', 'sexo', 'photo', 'ape1ape1', 'retiro', 'fecha_ret', 'mat_bajo_p1', 'mat_bajo_p2', 'mat_bajo_p3', 'mat_bajo_p4', 'email_instit', 'clave_instit', 'annio_pagado'],
    ];
  
    self::$_attribs = [
      'id'        => 'required',
      'uuid'      => 'required',
      'nombres'   => 'required',
      'apellido1' => 'required',
    ];
  
    self::$_defaults = [
      'mes_pagado'     => 2,
      'is_active'       => 1,
    ];
  
    self::$_helps = [
      'fecha_nac'    => 'aaaa/mm/dd, ej 2014/10/31',
      'fecha_ret'    => 'dd/mm/aaaa, ej 30/07/2014',
      'is_debe_preicfes'  => 'Debe PREICFES?',
      'is_debe_almuerzos' => 'Debe ALMUERZOS?',
      'is_habilitar_mat'  => 'El PADRE ya ACEPT&Oacute; la matricula?',
      'mes_pagado'        => 'Hasta que mes de pensión está pago',
      'documento'    => 'Sin puntos ni comas',
      'is_active'    => 'Indica si está activo el registro.',
    ];
  
    self::$_labels = [
      'nombres'    => 'Nombres',
      'salon_id'   => 'Salón',
      'apellido1'  => 'Primer Apellido',
      'apellido2'  => 'Segundo Apellido',
      'grado_mat'  => 'Grado',
      'numero_mat' => '# Matricula',
      'tipo_dcto'  => 'Tipo Documento',
      'retiro'     => 'Motivo Retiro',
      'fecha_ret'  => 'Fecha Ingreso/Retiro',
      'documento'  => 'Documento Id.',
      'fecha_nac'  => 'Fecha Nac.',
      'is_debe_preicfes'  => '¿Debe PREICFES?',
      'is_debe_almuerzos' => '¿Debe ALMUERZOS?',
      'is_habilitar_mat'  => 'Aceptó Matr&iacute;cula?',
      'mes_pagado'        => 'Pagó pensión hasta',
      'email_instit'      => 'Usuario',
      'clave_instit'      => 'Clave',
      
      'estudiante_nombre' => 'Estudiante',

      'is_active'       => 'Estado',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
    ];

  }//END-setUp


} //END-SetUp