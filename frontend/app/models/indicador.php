<?php
/**
 * Modelo Indicador * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */
  
class Indicador extends LiteRecord {

  use IndicadorTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.indicadores');
    self::$order_by_default = 't.annio, t.periodo_id, t.grado_id, t.asignatura_id, t.codigo';
    $this->setUp();
  } //END-__construct

  const IS_visible  = [0 => 'No visible', 1 => 'Visible' ];
  public static $valorativos = ['Fortaleza'=>'Fortaleza', 'Debilidad'=>'Debilidad', 'Recomendación'=>'Recomendación'];
  
  /**
   * Regresa Lista de indicadores filtrada
   */
  public function getListIndicadores(int $periodo_id, int $grado_id, int $asignatura_id) {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.*, g.nombre as grado_nombre, a.nombre as asignatura_nombre')
        ->where('t.is_active=1 AND t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
        ->leftJoin('grado', 'g')
        ->leftJoin('asignatura', 'a')
        ->orderBy(self::$order_by_default)
        ->setParams([$periodo_id, $grado_id, $asignatura_id]);
    return $DQL->execute();
  } // END-getListIndicadores



} //END-CLASS