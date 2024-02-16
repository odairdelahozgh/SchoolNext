<?php

trait DatosEstudTraitProps 
{

  public function getAcudiente() 
  {
    if ('MADRE' == strtoupper(trim($this->tipo_acudi)) ) 
    {
      return $this->madre;
    }
    if ('PADRE' == strtoupper(trim($this->tipo_acudi)) ) 
    {
      return $this->padre;
    }    
    return $this->acudiente;
  }
  

  public function getInfoContactoAcudiente() 
  {
    if ('MADRE' == strtoupper(trim($this->tipo_acudi)) ) 
    {
      return "$this->madre $this->madre_tel_1";
    }
    if ('PADRE' == strtoupper(trim($this->tipo_acudi)) ) 
    {
      return "$this->padre $this->padre_tel_1";
    }    
    return "$this->acudiente $this->acudi_tel_1";
  }


  
}