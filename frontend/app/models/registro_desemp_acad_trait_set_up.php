<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait RegistroDesempAcadTraitSetUp {
  
  use TraitUuid, TraitForms, RegistroDesempAcadTraitProps;
  
  public function validar($input_post) {
    try{
      Session::set('error_validacion', '');
      if (!validar::numericVal()->validate($input_post['estudiante_id'])) {
        Session::set('error_validacion', 'Error evaluando Estudiante');
        return false;
      }
      
      if (!validar::numericVal()->positive()->length(4)->validate((int)$input_post['annio'])) {
        Session::set('error_validacion', 'Error evaluando Año');
        return false;
      }

      if (!validar::numericVal()->positive()->validate((int)$input_post['grado_id'])) {
        Session::set('error_validacion', 'Error evaluando Grado');
        return false;
      }
      if (!validar::numericVal()->positive()->validate((int)$input_post['salon_id'])) {
        Session::set('error_validacion', 'Error evaluando Salon');
        return false;
      }
      return true;
    } catch (\Throwable $th) {
      OdaFlash::error($th, true);
    }
  } //END-validar

  /**
   * CONFIGURACIÓN DEL MODELO
   */
  private function setUp() {

    self::$_fields_show = [
      'all'       => ['id', 'uuid', 'estudiante_id', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'fortalezas', 'dificultades', 'compromisos', 'fecha', 'acudiente', 'foto_acudiente', 'director', 'foto_director', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'index'     => ['created_by', 'estudiante_id', 'fecha', 'annio', 'periodo_id', 'grado_id', 'salon_id' ],
      'create'    => ['periodo_id', 'fortalezas', 'dificultades', 'compromisos', 'fecha', 'acudiente', 'foto_acudiente', 'director', 'foto_director'],
      'edit'      => ['periodo_id', 'fortalezas', 'dificultades', 'compromisos', 'fecha', 'acudiente', 'foto_acudiente', 'director', 'foto_director'],
      'editUuid'  => ['periodo_id', 'fortalezas', 'dificultades', 'compromisos', 'fecha', 'acudiente', 'foto_acudiente', 'director', 'foto_director'],
    ];
  
    self::$_attribs = [
      'estudiante_id'   => 'required',
      'annio'           => 'required',
      'periodo_id'      => 'required',
      'grado_id'        => 'required',
      'salon_id'        => 'required',
      'fortalezas'      => 'required',
      'dificultades'    => 'required',
      'compromisos'     => 'required',
      'fecha'           => 'required',
      'acudiente'       => 'required',
      'director'        => 'required',
      
      'id'       => 'required',
      'uuid'     => 'required',
    ];
  
    self::$_defaults = [
      'is_active'   => 1,
    ];
  
    self::$_helps = [
      'foto_acudiente'  => 'Evidencia Acudiente. Archivo tipo imagen [jpg, png, gif, jpeg]',
      'foto_director'   => 'Evidencia Docente. Archivo tipo imagen [jpg, png, gif, jpeg]',
    ];
  
    self::$_labels = [
      'estudiante_id'   => 'Estudiante',
      'annio'           => 'Año',
      'periodo_id'      => 'Periodo',
      'grado_id'        => 'Grado',
      'salon_id'        => 'Salon',
      'fortalezas'      => 'Fortalezas',
      'dificultades'    => 'Dificultades',
      'compromisos'     => 'Compromisos',
      'fecha'           => 'Fecha de Registro',
      'acudiente'       => 'Acudiente',
      'foto_acudiente'  => 'Evidencia Acudiente',
      'director'        => 'Docente',
      'foto_director'   => 'Evidencia Docente',

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