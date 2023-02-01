<?php
trait IndicadorTraitDefa {

  public function getTLabels() {
    return array(
      'annio'           => 'Año',
      'periodo_id'      => 'Periodo',
      'grado_id'        => 'Grado',
      'asignatura_id'   => 'Asignatura',
      'codigo'          => '<i class="fa-solid fa-bolt w3-small"></i> Código',
      'concepto'        => '<i class="fa-solid fa-bolt w3-small"></i> Concepto',
      'valorativo'      => 'Valorativo',
      'is_visible'      => 'Visible en Calificar?',
      'is_active'       => 'Está Activo? ',
      'created_at'      => 'Creado el: ',
      'created_by'      => 'Creado por: ',
      'updated_at'      => 'Actualizado el: ',
      'updated_by'      => 'Actualizado por: ',
    );
  }

  public function getTDefaults() {
    return array(
      /*'annio'         => '',
      'periodo_id'      => '',
      'grado_id'        => '',
      'asignatura_id'   => '',
      'codigo'          => '',
      'concepto'        => '',
      'valorativo'      => '',
      'is_visible'      => '',*/
      'is_active'    => 1,
    );
  }

  public function getTHelps() {
    return array(
      'codigo'          => 'Min: 100  -  Max: 399 [Excepto Inglés]',
      /*'annio'         => '',
      'periodo_id'      => '',
      'grado_id'        => '',
      'asignatura_id'   => '',
      'concepto'        => '',
      'valorativo'      => '',
      'is_visible'      => '',*/
      'is_active'    => 'Indica si está activo el registro.',
    );
  }

  public function getTAttribs() {
    return array(
      'new' => [
        'codigo'        => 'required inputmode="numeric" pattern="\d*',
        'concepto'      => 'required',
        /*
        'periodo_id'      => '',
        'annio'           => '',
        'grado_id'        => '',
        'asignatura_id'   => '',
        'valorativo'      => '',
        'is_visible'      => '',
        */
        'is_active'    => '',
        'created_by'   => '',
        'updated_by'   => '',
        'created_at'   => '',
        'updated_at'   => '',
      ],
      'edit' => [
        'codigo'        => 'required inputmode="numeric" pattern="\d*',
        'concepto'      => 'required',
        /*
        'periodo_id'      => '',
        'annio'           => '',
        'grado_id'        => '',
        'asignatura_id'   => '',
        'valorativo'      => '',
        'is_visible'      => '',
        */
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
      'codigo'     => 'Fort:100-199 - Debil:200-299 - Recom:300-399',
      /*'annio'         => '',
      'periodo_id'      => '',
      'grado_id'        => '',
      'asignatura_id'   => '',
      'concepto'        => '',
      'valorativo'      => '',
      'is_visible'      => '',*/
    );
  }


} //END-TraitDefa