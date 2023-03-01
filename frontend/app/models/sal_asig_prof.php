<?php
/**
 * Modelo SalAsigProf * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

 /* 
 'id', 'salon_id', 'asignatura_id', 'user_id', 'pend_cal_p1', 'pend_cal_p2', 'pend_cal_p3', 'pend_cal_p4', 'pend_cal_p5'
*/
  
class SalAsigProf extends LiteRecord {

  use SalAsigProfTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.salon_asignat_profe');
    self::$order_by_default = 't.user_id, t.salon_id, t.asignatura_id';
    $this->setUp();
  } //END-__construct


  /**
   * Obtiene la Carga academica de un docente
   */
  public function getCarga(int $user_id) {
    $DQL = (new OdaDql(__CLASS__))
      ->select('t.*, s.nombre as salon, a.nombre as asignatura, s.grado_id, g.nombre as grado')
      ->concat(['u.nombres','u.apellido1', 'u.apellido2'], 'profesor')
      ->leftJoin('salon', 's')
      ->leftJoin('grado', 'g', condition:'s.grado_id=g.id')
      ->leftJoin('asignatura', 'a')
      ->leftJoin('usuario', 'u', condition:'t.user_id=u.id')
      ->where('s.is_active=1')
      ->orderBy('profesor, asignatura, salon');

    if ($user_id<>1) {
        $DQL->andWhere('t.user_id=?');
        $DQL->setParams([$user_id]);
    }
    return $DQL->execute();
  }//END-getCarga


  /**
   * Resumen Estadístico
   */
  public function getStats(int $user_id) {
    $DQL = (new OdaDql(__CLASS__))
      ->addSelect('DISTINCT s.grado_id, t.salon_id, t.asignatura_id, ga.intensidad')
      ->leftJoin('salon', 's', condition:'t.salon_id')
      ->where('s.is_active=1');
    if ($user_id<>1) {
        $DQL->andWhere('t.user_id=?');
        $DQL->setParams([$user_id]);
    }
    return $DQL->execute();
  }//END-getStats


} //END-CLASS