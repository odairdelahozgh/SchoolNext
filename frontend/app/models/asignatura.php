<?php
/**
  * Modelo Salon  
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
  */

class Asignatura extends LiteRecord
{
  protected static $table = 'sweb_asignaturas';
  
  const ESTADO = [
    0 => 'Inactivo',
    1 => 'Activo'
  ];
  
  
  //=============
  public $before_delete = 'no_borrar_activos';
  public function no_borrar_activos() {
    if($this->is_active==1) {
      OdaFlash::error('No se puede borrar un registro activo');
      return 'cancel';
    }
  } //END-no_borrar_activos
  
  //=============
  public function after_delete() {
    OdaFlash::valid("Se borró el registro");
  } //END-after_delete

  //=============
  public function before_create() { 
    $this->is_active = 1; 
  } //END-before_create

  public function __toString() { return $this->nombre; }
  
////////////////////////////////
//  MÉTODOS DE LA CLASE
////////////////////////////////

  
  //=============
  public function getListTodos() {
    return (new Salon)::all();
  } // END-getListTodos
    
  
}