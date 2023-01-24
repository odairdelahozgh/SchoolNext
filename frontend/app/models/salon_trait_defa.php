<?php
trait SalonTraitDefa {

  public function getTLabels() {
    return array(
      'is_active'         => 'Está Activo? ',
      'nombre'            => 'Salón',
      'grado_id'          => 'Grado',
      'director_id'       => 'Director',
      'codirector_id'     => 'Codirector',
      'position'          => 'Orden',
      'tot_estudiantes'   => 'ttoal Estuds',
      'print_state1'      => 'Estado Impresión P1',
      'print_state2'      => 'Estado Impresión P2',
      'print_state3'      => 'Estado Impresión P3',
      'print_state4'      => 'Estado Impresión P4',
      'print_state5'      => 'Estado Impresión P5',
      'is_ready_print'    => '¿Está listo para imprimir?',
      'print_state'       => 'Estado De Impresión',
      'created_at'        => 'Creado el: ',
      'created_by'        => 'Creado por: ',
      'updated_at'        => 'Actualizado el: ',
      'updated_by'        => 'Actualizado por: ',
    );
  }

  public function getTDefaults() {
    return array(
      'is_active'    => 1,
    );
  }

  public function getTHelps() {
    return array(
      'is_active'         => 'Indica si está activo el registro.',
      'nombre'            => 'Máximo 50 caracteres',
      'grado_id'          => '',
      'director_id'       => 'Director de Grupo',
      'codirector_id'     => 'Codirector de Grupo',
      'position'          => 'Orden en el que se muestra en los listados.',
      'tot_estudiantes'   => 'Valor calculado',
      'print_state1'      => 'Para el Periodo 1',
      'print_state2'      => 'Para el Periodo 2',
      'print_state3'      => 'Para el Periodo 3',
      'print_state4'      => 'Para el Periodo 4',
      'print_state5'      => 'Para el Periodo 5',
      'is_ready_print'    => '[Deprecated - No tiene uso]',
      'print_state'       => '[Deprecated - No tiene uso]',
    );
  }

  public function getTAttribs() {
    return array(
      'new' => [
         'is_active'    => '',
         'created_by'   => '',
         'updated_by'   => '',
         'created_at'   => '',
         'updated_at'   => '',
      ],
      'edit' => [
        'is_active'    => '',
        'created_by'   => '',
        'updated_by'   => '',
        'created_at'   => '',
        'updated_at'   => '',
      ],
    );
  }

  public function getTPlaceholders() {
    return  array(
    );
  }


} //END-TraitDefa