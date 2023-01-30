<?php

trait NotaTDefa {
  
  public $before_delete = 'no_borrar_activos';
  public function no_borrar_activos() {
    if($this->is_active==1) {
      OdaFlash::warning('No se puede borrar un registro activo');
      return 'cancel';
    }
  } // END-

  //=============
  public function after_delete() { 
    OdaFlash::valid('Se borró el registro'); 
  } // END-


    public function _beforeCreate() {
        parent::_beforeCreate();
    }
    
    public function _beforeUpdate() {
        parent::_beforeUpdate();
    }

    
    public function getTLabels() {
        return 
            array(
                'is_active'          => 'Está Activo? ',
                'created_at'         => 'Creado el: ',
                'created_by'         => 'Creado por: ',
                'updated_at'         => 'Actualizado el: ',
                'updated_by'         => 'Actualizado por: ',
          );
    }

    public function getTDefaults() {
        return 
            array(
                'is_active'          => 1,
            );
    }

    public function getTHelps() {
        return
            array(
                'is_active'          => 'Indica si está activo el registro.',
            );
    }

    public function getTAttribs() {
        return 
            array(
                'new' => [
                    'is_active'          => '',
                    'created_by'         => '',
                    'updated_by'         => '',
                    'created_at'         => '',
                    'updated_at'         => '',
                ],
                'edit' => [
                    'is_active'          => '',
                    'created_by'         => '',
                    'updated_by'         => '',
                    'created_at'         => '',
                    'updated_at'         => '',
                ],
            );
    }

    public function getTPlaceholders() {
        return 
            array(
            );
    }
}