<?php
/**
 * Modelo GradoAsignatura
 *  
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * 'asignatura_id', 'created_at', 'created_by', 'grado_id', 'intensidad', 'orden', 'updated_at', 'updated_by'
 */
  
class GradoAsignatura extends LiteRecord {

  use GradoAsignaturaTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.grados_asignat');
    self::$_order_by_defa = 't.orden';
    $this->setUp();
  } //END-__construct

  public function getByGrado(int $grado_id) {
    $DQL = new OdaDql(__CLASS__);
    $DQL->select('t.*, g.nombre AS grado_nombre, a.nombre AS asignatura_nombre, a.abrev AS asignatura_abrev')
        ->leftJoin('grado', 'g')
        ->leftJoin('asignatura', 'a')
        ->where('t.grado_id = ?')
        ->setParams([$grado_id])
        ->orderBy(self::$_order_by_defa);
        
    return $DQL->execute();
  } //end-getByGrado

  
} //END-CLASS