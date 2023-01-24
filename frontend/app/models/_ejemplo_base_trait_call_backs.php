<?php
trait EjemploBaseTraitCallBacks {
 
 public function _beforeCreate() { // ANTES de CREAR el Registro
   parent::_beforeCreate();
 }
 
 public function _afterCreate() { // DESPUÉS de CREAR el Registro
   parent::_afterCreate();
   //$this->uuid = $this->UUIDReal(parent::$tam_campo_uuid); // OJO:: ACTIVARLO si usa UUID
 }


 //=============
 public function _beforeUpdate() { // ANTES de ACTUALIZAR el Registro
   parent::_beforeUpdate();
   if (strlen($this->uuid)==0) { $this->uuid = $this->UUIDReal(parent::$tam_campo_uuid); } // OJO:: ACTIVARLO si usa UUID
 }
 
 public function _afterUpdate() { // DESPUÉS de ACTUALIZAR el Registro
   parent::_afterUpdate();
 }
 

 //=============
 public function _after_delete() {
  if($this->is_active==1) {
  OdaFlash::warning('No se puede borrar un registro activo');
  return 'cancel';
  }
 } // END-
 
 public function _before_delete() { 
   OdaFlash::valid('Se borró el registro'); 
 } // END-



} //END-Trait