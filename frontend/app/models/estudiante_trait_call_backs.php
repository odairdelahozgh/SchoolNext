<?php
trait EstudianteTraitCallBacks {

  /**
   * ANTES de CREAR el Registro
   */
  public function _beforeCreate() { 
    parent::_beforeCreate();
    $this->uuid = $this->UUIDReal(); // OJO:: ACTIVARLO si usa UUID
  }

  /**
   * DESPUÉS de CREAR el Registro
   */
  public function _afterCreate() { // DESPUÉS de CREAR el Registro
    parent::_afterCreate();
  }

  /**
   * ANTES de ACTUALIZAR el Registro
   */
  public function _beforeUpdate() {
    parent::_beforeUpdate();
    if (strlen($this->uuid)==0) { $this->uuid = $this->UUIDReal(); } // OJO:: ACTIVARLO si usa UUID
  }

  /**
   * DESPUÉS de ACTUALIZAR el Registro
   */
  public function _afterUpdate() {
    parent::_afterUpdate();
  }
  
  /*
  public function _after_delete() {
    if($this->is_active==1) {
      OdaFlash::warning('No se puede borrar un registro activo');
      return 'cancel';
    }
  } // END-_after_delete
 
  public function _before_delete() { 
    OdaFlash::valid('Se borró el registro'); 
  } // END-_before_delete
  */


} //END-TraitCallBacks