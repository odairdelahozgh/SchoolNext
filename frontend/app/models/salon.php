<?php

/**
  * Modelo Salon  
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
  */


  /*  CALLBACKS:
  _beforeCreate, _afterCreate, _beforeUpdate, _afterUpdate, _beforeSave, _afterSave */
  
  // crear registro:               ->create(array $data = []): bool {}
  // actualizar registro:          ->update(array $data = []): bool {}
  // Guardar registro:             ->save(array $data = []): bool {}
  // Eliminar registro por pk:     ::delete($pk): bool
  //
  // Buscar por clave pk:                 ::get($pk, $fields = '*') $fields: campos separados por coma
  // Todos los registros:                 ::all(string $sql = '', array $values = []): array {}
  // Primer registro de la consulta sql:  ::first(string $sql, array $values = [])//: static in php 8
  // Filtra las consultas                 ::filter(string $sql, array $values = []): array

class Salon extends LiteRecord
{
  use TraitUuid, GradoTraitCallBacks, GradoTraitDefa, GradoTraitProps;
    
  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.salon');
    self::$_defaults     = $this->getTDefaults();
    self::$_labels   = $this->getTLabels();
    self::$_placeholders = $this->getTPlaceholders();
    self::$_helps    = $this->getTHelps();
    self::$_attribs  = $this->getTAttribs();
  }
  
  /**
   * Devuelve lista de Salones.
   */
  public function getList($estado=null, $select='*') { 
    $DQL = "SELECT s.*, g.nombre AS grado, CONCAT(ud.nombres, ' ', ud.apellido1, ' ', ud.apellido2) AS director, 
              CONCAT(uc.nombres, ' ', uc.apellido1, ' ', uc.apellido2) AS codirector 
            FROM ".self::$table." AS s
      LEFT JOIN ".Config::get('tablas.grados')." AS g ON s.grado_id=g.id
      LEFT JOIN ".Config::get('tablas.user')." AS ud ON s.director_id=ud.id
      LEFT JOIN ".Config::get('tablas.user')." AS uc ON s.codirector_id=uc.id
      
      ";

    if (!is_null($estado)) {
      $DQL .= " WHERE (s.is_active=?) ORDER BY s.position ";
      return $this::all($DQL, array((int)$estado));
    }
    $DQL .= " ORDER BY s.position ";
    return $this::all($DQL);
  } // END-getList

  
  /**
   * Devuelve lista de SALONES ACTIVOS
   */
  public function getListActivos(string $select='*'): array {
    return $this->getList(1, $select);
  }

  /**
   * Devuelve lista de SALONES INACTIVOS
   */
  public function getListInactivos(string $select='*'): array {
    return $this->getList(0, $select);
  }
  

}