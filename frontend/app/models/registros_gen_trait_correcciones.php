<?php
trait RegistrosGenTraitCorrecciones {


  public function setRellenarUuid() {
    try {
      $this->setUUID_All_ojo();
    } catch (\Throwable $th) {
      throw $th;
    }
  }//END-getCorregirRegistrosHuerfanos

  public static function setCorregirRegistrosHuerfanos() {
    try {
    } catch (\Throwable $th) {
      throw $th;
    }
  }//END-getCorregirRegistrosHuerfanos



} //END-TraitCorrecciones