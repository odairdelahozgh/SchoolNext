<?php

/**
  * Modelo Seccion
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
*/
class Seccion extends LiteRecord
{
  // id, nombre, abrev, orden, is_active, color_text, color_bg
  // created_by, updated_by, created_at, updated_at
  protected static $table = 'sweb_secciones';
  public function __toString() { return $this->nombre; }
  
}