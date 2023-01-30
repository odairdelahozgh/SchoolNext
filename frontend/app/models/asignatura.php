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
  public function __toString() { return $this->nombre; }
    
}