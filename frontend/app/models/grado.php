<?php
/**
 * Modelo Grado * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */
 /*
  /* id, uuid, is_active, orden, nombre, abrev, seccion_id, 
  *  proximo_grado, salon_default, 
  *  valor_matricula, matricula_palabras, valor_pension, pension_palabras, proximo_salon, 
  *  created_by, updated_by, created_at, updated_at
  */
  
class Grado extends LiteRecord {

  use GradoTraitSetUp, GradoTraitProps;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.grados');
    self::$_order_by_defa = 't.orden';
    $this->setUp();
  } //END-__construct


  //==============
  public function getListSeccion($estado=null) {
    $DQL = "SELECT g.*, s.nombre AS seccion
            FROM ".self::$table." AS g
            LEFT JOIN ".Config::get('tablas.secciones')." AS s ON g.seccion_id=s.id";
    
    if (!is_null($estado)) {
      $DQL .= " WHERE (g.is_active=?) ORDER BY g.orden";
      return $this::all($DQL, array((int)$estado));
    }

    $DQL .= " ORDER BY g.orden";
    return $this::all($DQL);
  } // END-getList

  /**
   * Devuelve lista de todos los Registros.
   */
  public function getList(int|bool $estado=null, string $select='*', string|bool $order_by=null) {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.*, s.nombre AS seccion_nombre, s.nombre AS seccion')
        ->leftJoin('seccion', 's')
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


} //END-CLASS