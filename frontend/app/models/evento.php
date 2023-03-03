<?php
/**
 * Modelo Evento * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

 /* 
  id, nombre, uuid, fecha_desde, fecha_hasta, 
  is_active, created_at, created_by, updated_at, updated_by
*/
  
class Evento extends LiteRecord {

  use EventoTraitSetUp;

  public function __construct() {
    parent::__construct(); 
    self::$table = Config::get('tablas.evento');
    self::$order_by_default = 't.fecha_desde';
    $this->setUp();
  } //END-__construct

  public function getEventosDashboard() {
    $desde = (new DateTime())->sub(new DateInterval('P1W'))->format('Y-m-d');
    $hasta = (new DateTime())->add(new DateInterval('P3W'))->format('Y-m-d');

    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.*')
        ->where('(fecha_desde BETWEEN ? AND ?) OR (fecha_hasta BETWEEN ? AND ?)')
        ->orderBy(self::$order_by_default)
        ->setParams([$desde, $hasta, $desde, $hasta]);
    return $DQL->execute(true);
  }

} //END-CLASS