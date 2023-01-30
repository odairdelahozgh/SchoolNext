<?php

/**
  * Modelo Salon  
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
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

*/

class Salon extends LiteRecord
{
  use TraitUuid, GradoTraitCallBacks, GradoTraitDefa, GradoTraitProps;
  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.salones');
    self::$_defaults     = $this->getTDefaults();
    self::$_labels   = $this->getTLabels();
    self::$_placeholders = $this->getTPlaceholders();
    self::$_helps    = $this->getTHelps();
    self::$_attribs  = $this->getTAttribs();
    self::$class_name = __CLASS__;
    self::$order_by_default = 't.is_active DESC, t.nombre';
  }

  /**
   * Devuelve lista de Salones.
   */
  public function getList2($estado=null, $select='*', string|bool $order_by=null) { 
    $DQL = "SELECT s.*, g.nombre AS grado, CONCAT(ud.nombres, ' ', ud.apellido1, ' ', ud.apellido2) AS director, 
              CONCAT(uc.nombres, ' ', uc.apellido1, ' ', uc.apellido2) AS codirector 
            FROM ".self::$table." AS s
      LEFT JOIN ".Config::get('tablas.grados')." AS g ON s.grado_id=g.id
      LEFT JOIN ".Config::get('tablas.usuarios')." AS ud ON s.director_id=ud.id
      LEFT JOIN ".Config::get('tablas.usuarios')." AS uc ON s.codirector_id=uc.id";

    if (!is_null($estado)) {
      $DQL .= " WHERE (s.is_active=?) ORDER BY s.position ";
      return $this::all($DQL, array((int)$estado));
    }
    $DQL .= " ORDER BY s.position ";
    return $this::all($DQL);
  } // END-getList


  public function getList(int|bool $estado=null, $select='*', string|bool $order_by=null) { 
    $DQL = new OdaDql();
    $DQL->select("s.*, g.nombre AS grado")
        ->concat(concat: ['ud.nombres', 'ud.apellido1', 'ud.apellido2'], alias:'director')
        ->concat(concat: ['uc.nombres', 'uc.apellido1', 'uc.apellido2'], alias:'codirector')
        ->from(from_class:'Salon', alias:'s')
        ->leftJoin('grado', alias:'g', condition:'grado_id')
        ->leftJoin('usuario', alias:'ud', condition:'director_id')
        ->leftJoin('usuario', alias:'uc', condition:'codirector_id');
    if (!is_null($estado)) { $DQL->where("s.is_active=$estado"); }
    if (!is_null($order_by)) { $DQL->orderBy($order_by); }
    
    return $DQL->execute();
  }
}