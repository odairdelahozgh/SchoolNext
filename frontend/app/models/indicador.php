<?php
/**
  * Modelo Indicadores
  * @category App
  * @package Models 
  * @example annio, periodo_id, grado_id, asignatura_id, codigo, concepto, valorativo, is_visible, is_active, created_at, updated_at, created_by, updated_by
  * https://github.com/KumbiaPHP/ActiveRecord
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
  
  id, annio, periodo_id, grado_id, asignatura_id, 
  codigo, concepto, valorativo, is_visible, 
  is_active, created_at, updated_at, created_by, updated_by

*/

class Indicador extends LiteRecord
{
  use TraitUuid, IndicadorTraitCallBacks, IndicadorTraitDefa, IndicadorTraitProps, IndicadorTraitLinksOlds;
  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.indicadores');
    self::$_defaults     = $this->getTDefaults();
    self::$_labels       = $this->getTLabels();
    self::$_placeholders = $this->getTPlaceholders();
    self::$_helps        = $this->getTHelps();
    self::$_attribs      = $this->getTAttribs();
    self::$class_name = __CLASS__;
    self::$order_by_default = 't.annio, t.periodo_id, t.grado_id, t.asignatura_id, t.codigo';
  } //END-__construct
  
  const IS_visible  = [0 => 'No visible', 1 => 'Visible' ];
  public static $valorativos = ['Fortaleza'=>'Fortaleza', 'Debilidad'=>'Debilidad', 'Recomendación'=>'Recomendación'];
  
  /**
   * Regresa Lista de indicadores filtrada
   */
  public function getListIndicadores(int $periodo_id, int $grado_id, int $asignatura_id) {
    $DQL = new OdaDql();
    $DQL->select('t.*, g.nombre as grado_nombre, a.nombre as asignatura_nombre')
        ->where('t.is_active=1 AND t.periodo_id=? AND t.grado_id=? AND t.asignatura_id=?')
        ->from(__CLASS__)
        ->leftJoin('grado', 'g')
        ->leftJoin('asignatura', 'a')
        ->orderBy(self::$order_by_default)
        ->setParams([$periodo_id, $grado_id, $asignatura_id]);
    return $DQL->execute();
  } // END-getIndicadores


} //END-CLASS