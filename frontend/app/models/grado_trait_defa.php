<?php
trait GradoTraitDefa {
  
  public function getTLabels() {
    return array(
      'is_active'          => 'Está Activo? ',
      'orden'              => 'Orden: ',
      'nombre'             => 'Nombre del Grado: ',
      'abrev'              => 'Abreviatura: ',
      'seccion_id'         => 'Sección: ',
      'salon_default'      => 'Salón por defecto: ',
      'valor_matricula'    => 'Valor Matrícula: ',
      'matricula_palabras' => 'Valor Matrícula en palabras: ',
      'valor_pension'      => 'Valor Pensión: ',
      'pension_palabras'   => 'Valor Pensión en palabras: ',
      'proximo_grado'      => 'Próximo Grado: ',
      'proximo_salon'      => 'Próximo Salon: ',
      'created_at'         => 'Creado el: ',
      'created_by'         => 'Creado por: ',
      'updated_at'         => 'Actualizado el: ',
      'updated_by'         => 'Actualizado por: ',
    );
  }

  public function getTDefaults() {
    return array(
      'is_active'          => 1,
      'orden'              => 1,
      'nombre'             => '',
      'abrev'              => '',
      'seccion_id'         => 1,
      'salon_default'      => 1,
      'valor_matricula'    => 100000,
      'matricula_palabras' => '',
      'valor_pension'      => 100000,
      'pension_palabras'   => '',
      'proximo_grado'      => 1,
      'proximo_salon'      => 1,
    );
  }

  public function getTHelps() {
    return array(
      'is_active'          => 'Indica si está activo el registro.',
      'orden'              => 'Orden en el que se muestra en los listados.',
      'nombre'             => 'Máximo 50 caracteres.',
      'abrev'              => 'Máximo 10 caracteres.',
      'seccion_id'         => 'Elija una opción.',
      'salon_default'      => 'Salón por default.',
      'valor_matricula'    => 'Número sin puntos, ni comas, ni tildes.',
      'matricula_palabras' => 'to-do: hidden, hacer en automático',
      'valor_pension'      => 'Número sin puntos, ni comas, ni tildes.',
      'pension_palabras'   => 'to-do: hidden, hacer en automático',
      'proximo_grado'      => 'Próximo grado al promoverse.',
      'proximo_salon'      => 'Próximo salón al promoverse.',
      'created_by'         => 'Creado por:',
      'updated_by'         => 'Actualizado por',
      //'created_at'         => '',
      //'updated_at'         => '',
    );
  }

  public function getTAttribs() {
    return array(
      'new' => [
         'is_active'         => '',
         'nombre'            => 'required="required" maxlength="50"',
         'abrev'             => 'maxlength="10"',
         'created_by'        => '',
         'updated_by'        => '',
         'created_at'        => '',
         'updated_at'        => '',
      ],
      'edit' => [
        'is_active'          => '',
        'nombre'             => 'required="required" maxlength="50"',
        'abrev'              => 'maxlength="10"',
        'created_by'         => '',
        'updated_by'         => '',
        'created_at'         => '',
        'updated_at'         => '',
      ],
    );
  }

  public function getTPlaceholders() {
    return array(
      //'is_active'          => '',
      //'orden'              => '',
      'nombre'             => 'Nombre del Grado',
      'abrev'              => 'Abreviatura para el Grado',
      //'seccion_id'         => 'Sección',
      //'salon_default'      => '',
      //'valor_matricula'    => '',
      'matricula_palabras' => 'Valor matrícula en palabras',
      //'valor_pension'      => '',
      'pension_palabras'   => 'Valor pensión en palabras',
      //'proximo_grado'      => '',
      //'proximo_salon'      => '',
      //'created_by'         => '',
      //'updated_by'         => '',
      //'created_at'         => '',
      //'updated_at'         => '',
    );
  }


} //END-TraitDefa