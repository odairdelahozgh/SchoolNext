<?php
/**
 * Modelo SalAsigProf 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

 /* 
  // crear registro:               ->create(array $data = []): bool {}
  // actualizar registro:          ->update(array $data = []): bool {}
  // Guardar registro:             ->save(array $data = []): bool {}
  // Eliminar registro por pk:     ::delete($pk): bool
  // 
  // Buscar por clave pk:                 ::get($pk, $fields = '*') $fields: campos separados por coma
  // Todos los registros:                 ::all(string $sql = '', array $values = []): array {}
  // Primer registro de la consulta sql:  ::first(string $sql, array $values = [])//: static in php 8
  // Filtra las consultas                 ::filter(string $sql, array $values = []): array
    
  setActivar, setDesactivar
  getById, deleteById, getList, getListActivos, getListInactivos
  getByUUID, deleteByUUID, setUUID_All_ojo

  Para debuguear: debug, warning, error, alert, critical, notice, info, emergence
  OdaLog::debug(msg: "Mensaje", name_log:'nombre_log');
  
  id, salon_id, asignatura_id, user_id, pend_cal_p1, pend_cal_p2, pend_cal_p3, pend_cal_p4, pend_cal_p5
*/

class SalAsigProf extends LiteRecord
{
  use TraitUuid, SalAsigProfTraitCallBacks, SalAsigProfTraitDefa, SalAsigProfTraitProps,  SalAsigProfTraitLinksOlds;
  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.salon_asignat_profe');
    self::$_defaults     = $this->getTDefaults();
    self::$_labels       = $this->getTLabels();
    self::$_placeholders = $this->getTPlaceholders();
    self::$_helps        = $this->getTHelps();
    self::$_attribs      = $this->getTAttribs();
    self::$class_name = __CLASS__;
    self::$order_by_default = 't.user_id, t.salon_id, t.asignatura_id';
  }//END-__construct

  /**
   * Obtiene la Carga academica de un docente
   */
  public function getCarga(int $user_id) {
    $DQL = (new OdaDql)
      ->select('t.*, s.nombre as salon, a.nombre as asignatura, s.grado_id, g.nombre as grado')
      ->concat(['u.nombres','u.apellido1', 'u.apellido2'], 'profesor')
      ->from(from_class: __CLASS__)
      ->leftJoin('salon', 's')
      ->leftJoin('grado', 'g', 's.grado_id')
      ->leftJoin('asignatura', 'a')
      ->leftJoin('usuario', 'u', condition:'t.user_id')
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
    $DQL = (new OdaDql)
      ->addSelect('DISTINCT s.grado_id, t.salon_id, t.asignatura_id, ga.intensidad')
      ->from(from_class: 'SalAsigProf')
      ->leftJoin('salon', 's', condition:'t.salon_id')
      ->where('s.is_active=1');
    if ($user_id<>1) {
        $DQL->andWhere('t.user_id=?');
        $DQL->setParams([$user_id]);
    }
    return $DQL->execute();
  }//END-getStats


}//END-class SalAsigProf