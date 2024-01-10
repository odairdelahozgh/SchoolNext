<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */
  
class Plantillas extends LiteRecord 
{
  use PlantillasTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.plantillas');
    self::$_order_by_defa = 't.nombre';      
    $this->setUp();
  }

} //END-CLASS