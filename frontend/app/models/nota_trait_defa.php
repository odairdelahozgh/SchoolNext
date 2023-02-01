<?php
trait NotaTraitDefa {

  //definitiva, plan_apoyo, nota_final
  //i01, i02, i03, i04, i05, i06, i07, i08, i09, i10

  public function getTLabels() {
    return array(
      'is_active'    => 'Está Activo? ',
      'created_at'   => 'Creado el: ',
      'created_by'   => 'Creado por: ',
      'updated_at'   => 'Actualizado el: ',
      'updated_by'   => 'Actualizado por: ',
    );
  }

  public function getTDefaults() {
    return array(
      'is_active'    => 1,
    );
  }

  public function getTHelps() {
    return array(
      'is_active'    => 'Indica si está activo el registro.',
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