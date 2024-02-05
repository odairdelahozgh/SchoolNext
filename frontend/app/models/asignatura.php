<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */
  
include "asignatura/asignatura_trait_props.php";
include "asignatura/asignatura_trait_set_up.php";

class Asignatura extends LiteRecord {

  use AsignaturaTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.asignatura');
    $this->setUp();
  }

  public function getList(int|bool $estado=null, string $select='*', string|bool $order_by=null) 
  {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.*, a.nombre AS area_nombre')
        ->leftJoin('area', 'a')
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




}