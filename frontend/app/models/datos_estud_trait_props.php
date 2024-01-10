<?php

trait DatosEstudTraitProps 
{
  public function getAcudiente() 
  {
    if ('MADRE' == strtoupper(trim($this->tipo_acudi)) ) {
      return $this->madre;
    }
    if ('PADRE' == strtoupper(trim($this->tipo_acudi)) ) {
      return $this->madre;
    }
    return $this->acudiente;
  }
  
}