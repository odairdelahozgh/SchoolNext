<?php
trait RegistrosGenTraitDefa {

  //protected static $order_by_default = 'nombre ASC'; // default: id ASC

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