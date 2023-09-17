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
    self::$_order_by_defa = 't.user_id, t.salon_id, t.asignatura_id';
    $this->setUp();
  } //END-__construct


  public function getSalones_ByProfesor(int $user_id) {
    try {
      $DQL = (new OdaDql(__CLASS__));
      $DQL->setFrom(self::$table);
      $DQL->select('DISTINCT t.salon_id');
      if ($user_id<>1) {
        $DQL->where('t.user_id=?')
            ->setParams([$user_id]);
      }
      
      return $DQL->execute(true);
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getSalones_ByProfesor

  
  public function getCarga(int $user_id) {
    $DQL = (new OdaDql(__CLASS__))
      ->select('t.*')
      ->addSelect('s.nombre as salon_nombre, s.grado_id, s.tot_estudiantes')
      ->addSelect('a.nombre as asignatura_nombre')
      ->addSelect('g.nombre as grado_nombre')
      ->concat(['u.nombres','u.apellido1', 'u.apellido2'], 'profesor_nombre')
      ->leftJoin('salon', 's')
      ->leftJoin('grado', 'g', 's.grado_id=g.id')
      ->leftJoin('asignatura', 'a')
      ->leftJoin('usuario', 'u', 't.user_id=u.id')
      ->where('s.is_active=1')
      ->orderBy('asignatura_nombre, salon_nombre');

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
      ->leftJoin('salon', 's', 't.salon_id')
      ->where('s.is_active=1');
    if ($user_id<>1) {
        $DQL->andWhere('t.user_id=?');
        $DQL->setParams([$user_id]);
    }
    return $DQL->execute();
  }//END-getStats 
 
} //END-CLASS