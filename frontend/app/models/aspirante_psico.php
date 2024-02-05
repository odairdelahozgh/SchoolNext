<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */
  
include "aspirante/aspirante_psico_trait_set_up.php";

class AspirantePsico extends LiteRecord {
  use AspirantePsicoTraitSetUp;
  
  public function __construct() 
  {
    try {
      parent::__construct();
      self::$table = Config::get('tablas.aspirantes_psico');
      self::$_order_by_defa = 'id, aspirante_id';
      $this->setUp();
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }
  


}