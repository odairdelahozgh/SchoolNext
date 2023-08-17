<?php
/**
 * Modelo AspirantePsico
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */
  
class AspirantePsico extends LiteRecord {
  use AspirantePsicoTraitSetUp;
  
  public function __construct() {
    try {
      parent::__construct();
      self::$table = Config::get('tablas.aspirantes_psico');
      self::$_order_by_defa = 'id, aspirante_id';
      $this->setUp();
      } catch (\Throwable $th) {
        OdaFlash::error($th);
      }
    } //END-__construct
  


} //END-CLASS