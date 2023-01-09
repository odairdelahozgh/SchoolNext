<?php

trait UsuarioDefa {

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
                'username'   => 'Nombre de Usuario:',
                'roll'       => 'Roles de Usuario:',

                'nombres'    => 'Nombre(s):',
                'apellido1'  => 'Primer Apellido:',
                'apellido2'  => 'Segundo Apellido:',
                'fecha_nac'  => 'Fecha Nacimiento:',
                
                'direccion'  => 'Dirección:',
                'cargo'      => 'Cargo:',
                'fecha_nac'  => 'Fecha Nacimiento:',
                'documento'  => 'Nro. Documento:',
                'telefono1'  => 'Teléfono Principal:',
                'telefono2'  => 'Teléfono Secundario:',
                'sexo'       => 'Sexo:',
                
                'profesion'         => 'Profesión:',
                'is_carga_acad_ok'  => 'Carga Académicas:',

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
                'fecha_nac'    => 'dd/mm/aaaa - Ejemplo: 26/07/1976',
                'documento'    => 'Advertencia!! sin puntos, sin comas.',
                
                'is_active'          => 'Indica si está activo el registro.',
                'created_by'         => 'Creado por:',
                'updated_by'         => 'Actualizado por',
                'created_at'         => 'Creación del Registro',
                'updated_at'         => 'Última Actualización del Registro',
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