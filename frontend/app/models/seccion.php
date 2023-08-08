<?php
/**
 * Modelo Seccion
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

class Seccion extends LiteRecord {

  use SeccionTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.seccion');
    self::$_order_by_defa = 't.nombre';
    $this->setUp();
  } //END-__construct


} //END-CLASS