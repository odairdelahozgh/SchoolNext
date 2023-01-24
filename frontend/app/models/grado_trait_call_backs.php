<?php
trait GradoTraitCallBacks {
 
  public function _beforeCreate() { // ANTES de CREAR el Registro
    parent::_beforeCreate();
    $this->abrev = strtoupper($this->abrev);
    $this->matricula_palabras = strtolower(OdaUtils::getNumeroALetras($this->valor_matricula));
    $this->pension_palabras = strtolower(OdaUtils::getNumeroALetras($this->valor_pension));
    $this->uuid = $this->UUIDReal();
  }
 
  public function _afterCreate() { // DESPUÉS de CREAR el Registro
    parent::_afterCreate();
  }


 //=============
  public function _beforeUpdate() { // ANTES de ACTUALIZAR el Registro
    parent::_beforeUpdate();
    if (strlen($this->uuid)==0) { $this->uuid = $this->UUIDReal(); }
    $this->matricula_palabras = strtolower(OdaUtils::getNumeroALetras($this->valor_matricula));
    $this->pension_palabras = strtolower(OdaUtils::getNumeroALetras($this->valor_pension));
  }
 
  public function _afterUpdate() { // DESPUÉS de ACTUALIZAR el Registro
    parent::_afterUpdate();
  }
 
/* 
  //=============
  public function _after_delete() {
    if ($this->is_active==1) {
      OdaFlash::warning('No se puede borrar un registro activo');
    return 'cancel';
    }
  } // END-
 
  public function _before_delete() { 
    OdaFlash::valid('Se borró el registro'); 
  } // END-

 */

} //END-Trait