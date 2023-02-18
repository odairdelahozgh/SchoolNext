<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait SalonTraitSetUp {
  
  use TraitUuid, TraitForms;
  
  public function __toString() { return $this->nombre; } 

  public function validar($input_post) {
    Session::set('error_validacion', '');
    try {
      validar::number()->length(1)->min(0)->max(1)->assert($input_post['is_active']);
      validar::alnum()->assert($input_post['nombre']);
      if ($input_post['director_id']) {
        validar::number()->assert($input_post['director_id']);
      }
      if ($input_post['codirector_id']) {
        validar::number()->assert($input_post['codirector_id']);
      }
      if ($input_post['position']) {
        validar::number()->assert($input_post['position']);
      }
      if ($input_post['tot_estudiantes']) {
        validar::number()->assert($input_post['tot_estudiantes']);
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
      'all'      => ['nombre', 'grado_id', 'director_id', 'codirector_id', 'tot_estudiantes', 'position', 'print_state1', 'print_state2', 'print_state3', 'print_state4', 'print_state5', 'is_ready_print', 'print_state', 'id', 'uuid', 'is_active', 'created_by', 'created_at', 'updated_by', 'updated_at'],
      'index'    => ['is_active', 'nombre', 'grado_id', 'director_id', 'codirector_id', 'tot_estudiantes', 'print_state'],
      'create'   => ['nombre', 'grado_id', 'director_id', 'codirector_id', 'position', 'print_state1', 'print_state2', 'print_state3', 'print_state4', 'print_state5', 'is_ready_print', 'print_state', 'is_active' ],
      'edit'     => ['nombre', 'grado_id', 'director_id', 'codirector_id', 'tot_estudiantes', 'position', 'print_state1', 'print_state2', 'print_state3', 'print_state4', 'print_state5', 'is_ready_print', 'print_state', 'is_active' ],
      'editUuid' => ['nombre', 'grado_id', 'director_id', 'codirector_id', 'tot_estudiantes', 'position', 'print_state1', 'print_state2', 'print_state3', 'print_state4', 'print_state5', 'is_ready_print', 'print_state', 'is_active' ],
    ];
  
    self::$_attribs = [
      'nombre'    =>  'required', 
      'grado_id'  =>  'required',

      'id'        =>  'required',
      'uuid'      =>  'required',
    ];
  
    self::$_defaults = [
      'tot_estudiantes' => 0, 
      'position'        => 0,
      'print_state1'    => 'En Calificación',
      'print_state2'    => 'En Calificación',
      'print_state3'    => 'En Calificación',
      'print_state4'    => 'En Calificación',
      'print_state5'    => 'En Calificación',
      'print_state'     => 'En Calificación',
      'is_ready_print'  => 0,

      'is_active'       => 1,
    ];
  
    self::$_helps = [
    'nombre'            => 'Máximo 50 caracteres',
    'grado_id'          => 'Elija Grado al que pertenece',
    'director_id'       => 'Director de Grupo',
    'codirector_id'     => 'Codirector de Grupo',
    'position'          => 'Orden en el que se muestra en los listados.',
    'tot_estudiantes'   => 'Valor calculado',
    'print_state1'      => 'Estado de la impresión para el Periodo 1',
    'print_state2'      => 'Estado de la impresión para el Periodo 2',
    'print_state3'      => 'Estado de la impresión para el Periodo 3',
    'print_state4'      => 'Estado de la impresión para el Periodo 4',
    'print_state5'      => 'Estado de la impresión para el Periodo 5',
    'is_ready_print'    => '[Deprecated - No tiene uso]',
    'print_state'       => '[Deprecated - No tiene uso]',

    'is_active'         => 'Indica si está activo el registro.',
    ];
  
    self::$_labels = [
      'nombre'            => 'Salon',
      'grado_id'          => 'Grado',
      'director_id'       => 'Director',
      'codirector_id'     => 'Codirector',
      'position'          => 'Orden',
      'tot_estudiantes'   => 'Total Estudiantes',
      'print_state1'      => 'Estado Impresión P1',
      'print_state2'      => 'Estado Impresión P2',
      'print_state3'      => 'Estado Impresión P3',
      'print_state4'      => 'Estado Impresión P4',
      'print_state5'      => 'Estado Impresión P5',
      'is_ready_print'    => '¿Está listo para imprimir?',
      'print_state'       => 'Estado De Impresión',

      'is_active'         => 'Está Activo? ',
      'created_at'        => 'Creado el',
      'created_by'        => 'Creado por',
      'updated_at'        => 'Actualizado el',
      'updated_by'        => 'Actualizado por',
    ];
  
    self::$_placeholders = [
      'nombre'          => 'nombre del salon',
    ];
  

  }
} //END-SetUp