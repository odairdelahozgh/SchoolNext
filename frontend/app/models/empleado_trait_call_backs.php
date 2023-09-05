<?php

trait EmpleadoTraitCallBacks {

  public function _beforeCreate() {
    try {
      parent::_beforeCreate();
      $this->algortithm = 'sha1';

      $salt = md5(rand(100000, 999999).$this->username);
      $this->salt = $salt;
     
      $pass = substr($this->documento, -4);
      $password_salt = hash($this->algortithm, $this->salt.$pass);
      $this->password = $password_salt;
      
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-_beforeUpdate
  
  
  public function _afterCreate() {
    try {
      parent::_afterCreate();

   } catch (\Throwable $th) {
     OdaFlash::error($th);
   }
  } //END-_afterCreate


 public function _beforeUpdate() {
   try {
    parent::_beforeUpdate();
    
  } catch (\Throwable $th) {
    OdaFlash::error($th);
  }
 } //END-_beforeUpdate
 

} //END-Trait