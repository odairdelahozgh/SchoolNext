<?php
/**
 * Modelo Periodo * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 *
 * 'id', 'periodo', 'fecha_inicio', 'fecha_fin', 'mes_req_boletin'
 * 'f_ini_logro', 'f_fin_logro', 'f_ini_notas', 'f_fin_notas', 'f_open_day', 
 * 'created_by', 'updated_by', 'created_at', 'updated_at'
*/
  
class Periodo extends LiteRecord {

  use PeriodoTraitSetUp;
  const PERIODOS = [1,2,3,4];

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.periodo');
    $this->setUp();
  } //END-__construct
  
  public function getPeriodoActual($periodo=null) {
    $pk = (!is_null($periodo)) ? $periodo : Config::get('config.academic.periodo_actual');
    return $this->get($pk);
  } //END-getPeriodoActual
  
  

} //END-CLASS