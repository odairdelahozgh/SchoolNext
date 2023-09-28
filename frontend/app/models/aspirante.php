<?php
/**
 * Modelo Aspirante  
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */
  
class Aspirante extends LiteRecord {
  use AspiranteTraitSetUp;
  
  public function __construct() {
    try {
      parent::__construct();
      self::$table = Config::get('tablas.aspirante');
      self::$_order_by_defa = 't.is_active DESC,T.fecha_insc DESC, t.estatus,t.grado_aspira,t.apellido1,t.apellido2,t.nombres';
      $this->setUp();
      } catch (\Throwable $th) {
        OdaFlash::error($th);
      }
    } //END-__construct
  
    public function getList(int|bool $estado=null, string $select='*', string|bool $order_by=null) {
      $DQL = (new OdaDql(__CLASS__))
          ->select($select)
          ->concat(['apellido1, " ", apellido2, " ", nombres'], 'aspirante_nombre')
          ->addSelect('t.grado_aspira, g.nombre as aspirante_grado')
          ->leftJoin('grado', 'g', 't.grado_aspira = g.id')
          ->orderBy(self::$_order_by_defa);
      if (!is_null($order_by)) { $DQL->orderBy($order_by); }

     return $DQL->execute(true);
   } // END-getList
  

} //END-CLASS