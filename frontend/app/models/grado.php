<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */

include "grado/grado_trait_props.php";
include "grado/grado_trait_set_up.php";

class Grado extends LiteRecord {

  use GradoTraitSetUp, GradoTraitProps;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.grados');
    self::$_order_by_defa = 't.orden';
    $this->setUp();
  }


  public function getListSeccion($estado=null): array 
  {
    $DQL = "SELECT g.*, s.nombre AS seccion
            FROM ".self::$table." AS g
            LEFT JOIN ".Config::get('tablas.secciones')." AS s ON g.seccion_id=s.id";    
    if (!is_null($estado))
    {
      $DQL .= " WHERE (g.is_active=?) ORDER BY g.orden";
      return $this::all($DQL, array((int)$estado));
    }
    $DQL .= " ORDER BY g.orden";    
    return $this::all($DQL);
  }


  public function getList(int|bool $estado=null, string $select='*', string|bool $order_by=null) 
  {
    $DQL = new OdaDql(__CLASS__);  
    $DQL->select('t.*, t.nombre AS grado_nombre, s.nombre AS seccion_nombre, s.nombre AS seccion')
        ->leftJoin('seccion', 's')
        ->orderBy(self::$_order_by_defa);
    if (!is_null($order_by))
    {
      $DQL->orderBy($order_by);
    }
    if (!is_null($estado))
    { 
      $DQL->where('t.is_active=?')
          ->setParams([$estado]);
    }
    return $DQL->execute();
  }

  

}