<?php

/**
 * Modelo Indicador
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * 'id', 'uuid', 'annio', 'periodo_id', 'grado_id', 'asignatura_id', 'codigo', 'concepto', 'valorativo', 'is_visible', 'is_active', 'created_at', 'updated_at', 'created_by', 'updated_by'
 */
  
class Indicador extends LiteRecord {

  use IndicadorTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.indicadores');
    self::$order_by_default = 't.annio, t.periodo_id, t.grado_id, t.asignatura_id, t.codigo';
    $this->setUp();
  } //END-__construct

  //const IS_visible  = [0 => 'No visible', 1 => 'Visible' ];
  //const VALORATIVOS  = ['Fortaleza'=>'Fortaleza', 'Debilidad'=>'Debilidad', 'Recomendación'=>'Recomendación'];
  //public static $valorativos = ['Fortaleza'=>'Fortaleza', 'Debilidad'=>'Debilidad', 'Recomendación'=>'Recomendación'];

  /**
   * Devuelve lista de todos los Registros.
   */
  public function getList(int|bool $estado=null, string $select='*', string|bool $order_by=null) {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select("t.*, CONCAT('Periodo ', p.periodo) as periodo_nombre, g.nombre AS grado_nombre, a.nombre AS asignatura_nombre")
        ->leftJoin('periodo', 'p')
        ->leftJoin('grado', 'g')
        ->leftJoin('asignatura', 'a')
        ->orderBy(self::$order_by_default);
    if (!is_null($order_by)) {
      $DQL->orderBy($order_by);
    }
    if (!is_null($estado)) { 
      $DQL->where('t.is_active=?')
          ->setParams([$estado]);
    }
    return $DQL->execute();
  }

  /**
   * Regresa Lista de indicadores filtrada
   */
  public function getListIndicadores(int $periodo_id, int $grado_id, int $asignatura_id) {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.*, g.nombre as grado_nombre, a.nombre as asignatura_nombre')
        ->where('t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
        ->leftJoin('grado', 'g')
        ->leftJoin('asignatura', 'a')
        ->orderBy(self::$order_by_default)
        ->setParams([$periodo_id, $grado_id, $asignatura_id]);
    return $DQL->execute();
  } // END-getListIndicadores

  /**
   * Regresa Lista de indicadores filtrada
   */
  public function getListIndicadoresVisibles(int $periodo_id, int $grado_id, int $asignatura_id) {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.*, g.nombre as grado_nombre, a.nombre as asignatura_nombre')
        ->where('t.is_visible=1 AND t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
        ->leftJoin('grado', 'g')
        ->leftJoin('asignatura', 'a')
        ->orderBy(self::$order_by_default)
        ->setParams([$periodo_id, $grado_id, $asignatura_id]);
    return $DQL->execute();
  } // END-getListIndicadores


  public function getIndicadoresCalificar(int $periodo_id, int $grado_id, int $asignatura_id) {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.codigo, t.valorativo, t.concepto')
        ->where('t.is_active=1 AND t.is_visible=1 AND t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
        ->orderBy(self::$order_by_default)
        ->setParams([$periodo_id, $grado_id, $asignatura_id]);
    return $DQL->execute();
  } // END-getListIndicadores


} //END-CLASS