<?php
/**
  * Modelo Periodo  
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
  */
class Periodo extends LiteRecord
{
  protected static $table = 'sweb_periodos';
  /**
   * id, periodo, fecha_inicio, fecha_fin, 
   * f_ini_logro, f_fin_logro, 
   * f_ini_notas, f_fin_notas, 
   * f_open_day, mes_req_boletin,
   * created_by, updated_by, created_at, updated_at
   */
  const PERIODOS = [1,2,3,4];  
  
  
  //=============
  public function getPeriodoActual($periodo=null) {
    $pk = (!is_null($periodo)) ? $periodo : Config::get('config.academic.periodo_actual');
    return $this->get($pk);
  } //END-getPeriodoActual
  
  
  
}