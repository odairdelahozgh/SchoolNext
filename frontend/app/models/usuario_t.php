<?php

trait UsuarioT {

    // En la nueva versión se eliminarán estpa dos campos: matricula_palabras y pension_palabras
    public function _beforeCreate() { // Antes de Crear el nuevo registro
        parent::_beforeCreate();
    }
    
    public function _beforeUpdate() { // Antes de Crear el nuevo registro
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
                'created_by'         => 'Creado por:',
                'updated_by'         => 'Actualizado por',
                //'created_at'         => '',
                //'updated_at'         => '',
            );
    }

    public function getTAttribs() {
        return 
            array(
                //'is_active'          => '',
                //'created_by'         => '',
                //'updated_by'         => '',
                //'created_at'         => '',
                //'updated_at'         => '',
            );
    }

    public function getTPlaceholders() {
        return 
            array(
                //'is_active'          => '',
                //'created_by'         => '',
                //'updated_by'         => '',
                //'created_at'         => '',
                //'updated_at'         => '',
            );
    }
    
    
}