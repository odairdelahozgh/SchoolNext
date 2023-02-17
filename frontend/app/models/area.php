<?php
/**
 * Modelo Area
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

 /* 
  id, nombre, orden, created_by, updated_by, created_at, updated_at, is_active
*/

class Area extends LiteRecord
{
  use AreaTraitSetUp;
  
  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.areas');
    $this->setUp();
  } //END-__construct

} //END-CLASS