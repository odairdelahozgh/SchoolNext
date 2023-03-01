<?php
/**
 * Modelo Asignatura  
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * id, nombre, abrev, orden, created_by, updated_by, created_at, updated_at, area_id, is_active, calc_prom
 */
  
class Asignatura extends LiteRecord {

  use AsignaturaTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.asignatura');
    $this->setUp();
  } //END-__construct

  public function __toString() { return $this->nombre; }

  public function getList(int|bool $estado=null, string $select='*', string|bool $order_by=null) {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.*, a.nombre AS area_nombre')
        ->leftJoin('area', 'a')
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
} //END-CLASS