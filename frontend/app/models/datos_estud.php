<?php
/**
 * Modelo DatosEstud * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

class DatosEstud extends LiteRecord {

  use DatosEstudTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.datosestud');
    $this->setUp();
  } //END-__construct


} //END-CLASS