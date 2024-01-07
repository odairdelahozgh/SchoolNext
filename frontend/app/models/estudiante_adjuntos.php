<?php
/**
 * Modelo 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */
  
class EstudianteAdjuntos extends LiteRecord {

  use EstudianteAdjuntosTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.estud_adjuntos');
    $this->setUp();
  } //END

} //END-CLASS