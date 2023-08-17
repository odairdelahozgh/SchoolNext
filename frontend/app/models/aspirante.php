<?php
/**
 * Modelo Aspirante  
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */
  
class Aspirante extends LiteRecord {
  use AspiranteTraitSetUp;
  
  public function __construct() {
    try {
      parent::__construct();
      self::$table = Config::get('tablas.aspirante');
      self::$_order_by_defa = 't.estatus,t.apellido1,t.apellido2,t.nombres';
      $this->setUp();
      } catch (\Throwable $th) {
        OdaFlash::error($th);
      }
    } //END-__construct
  


} //END-CLASS