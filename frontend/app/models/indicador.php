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
    self::$_order_by_defa = 't.annio, t.periodo_id, t.grado_id, t.asignatura_id, t.codigo';
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
        ->orderBy(self::$_order_by_defa);
    if (!is_null($order_by)) {
      $DQL->orderBy($order_by);
    }
    if (!is_null($estado)) { 
      $DQL->where('t.is_active=?')
          ->setParams([$estado]);
    }
    return $DQL->execute();
  }

  
  public function getByPeriodoGrado(int $periodo_id, int $grado_id): array|string {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.*, g.nombre as grado_nombre, a.nombre as asignatura_nombre')
        ->leftJoin('grado', 'g')
        ->leftJoin('asignatura', 'a')
        ->where('t.periodo_id=? AND t.grado_id=?')
        ->orderBy(self::$_order_by_defa)
        ->setParams([$periodo_id, $grado_id]);
    return $DQL->execute();
  } // END-getByPeriodoGrado

  public function getByPeriodoGradoAsignatura(int $periodo_id, int $grado_id, int $asignatura_id): array|string {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.*, g.nombre as grado_nombre, a.nombre as asignatura_nombre')
        ->where('t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
        ->leftJoin('grado', 'g')
        ->leftJoin('asignatura', 'a')
        ->orderBy(self::$_order_by_defa)
        ->setParams([$periodo_id, $grado_id, $asignatura_id]);
    return $DQL->execute();
  } // END-getByPeriodoGradoAsignatura

  public function getByGradoAsignatura(int $grado_id, int $asignatura_id): array|string {
    try {
      $DQL = new OdaDql(__CLASS__);
      $DQL->select('t.*, g.nombre as grado_nombre, a.nombre as asignatura_nombre')
          ->where('t.grado_id=? AND t.asignatura_id=?')
          ->leftJoin('grado', 'g')
          ->leftJoin('asignatura', 'a')
          ->orderBy(self::$_order_by_defa)
          ->setParams([$grado_id, $asignatura_id]);
      return $DQL->execute();

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } // END-getByGradoAsignatura


  public function getListIndicadores(int $periodo_id, int $grado_id, int $asignatura_id) {
    try {
      $DQL = new OdaDql(__CLASS__);
      $DQL->select('t.*, g.nombre as grado_nombre, a.nombre as asignatura_nombre')
          ->where('t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
          ->leftJoin('grado', 'g')
          ->leftJoin('asignatura', 'a')
          ->orderBy(self::$_order_by_defa)
          ->setParams([$periodo_id, $grado_id, $asignatura_id]);
      return $DQL->execute();

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } // END-getListIndicadores


  public function getListIndicadoresVisibles(int $periodo_id, int $grado_id, int $asignatura_id) {
    try {
      $DQL = new OdaDql(__CLASS__);
      $DQL->select('t.*, g.nombre as grado_nombre, a.nombre as asignatura_nombre')
          ->where('t.is_active=1 AND t.is_visible=1 AND t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
          ->leftJoin('grado', 'g')
          ->leftJoin('asignatura', 'a')
          ->orderBy(self::$_order_by_defa)
          ->setParams([$periodo_id, $grado_id, $asignatura_id]);
      return $DQL->execute();

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } // END-getListIndicadoresVisibles


  public function getIndicadoresCalificar(int $periodo_id, int $grado_id, int $asignatura_id) {
    try {
      $DQL = new OdaDql(__CLASS__);
      $DQL->select('t.codigo, t.valorativo, t.concepto')
          //->where('t.is_active=1 AND t.is_visible=1 AND t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
          ->where('t.is_active=1 AND t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
          ->orderBy(self::$_order_by_defa)
          ->setParams([$periodo_id, $grado_id, $asignatura_id]);

      return $DQL->execute();
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }

  } // END-getIndicadoresCalificar

  public function getMinMaxByPeriodoGradoAsignatura(int $periodo_id, int $grado_id, int $asignatura_id) {
    try {
      $DQL = new OdaDql(__CLASS__);
      $DQL->select('t.valorativo, MIN(t.codigo) AS min, MAX(t.codigo) AS max')
          ->where('t.is_active=1 AND t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
          ->groupBy('t.valorativo')
          ->orderBy(self::$_order_by_defa)
          ->setParams([$periodo_id, $grado_id, $asignatura_id]);
      return $DQL->execute();
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } // END-getMinMaxByPeriodoGradoAsignatura


} //END-CLASS