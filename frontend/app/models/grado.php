<?php

/**
  * Modelo GRADO
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

  /* id, uuid, is_active, orden, nombre, abrev, seccion_id, 
  *  proximo_grado, salon_default, 
  *  valor_matricula, matricula_palabras, valor_pension, pension_palabras, proximo_salon, 
  *  created_by, updated_by, created_at, updated_at
  */

class Grado extends LiteRecord
{
  use TraitUuid, GradoTraitCallBacks, GradoTraitDefa, GradoTraitProps;
  
  public function __construct() {
    parent::__construct();
    self::$_defaults     = $this->getTDefaults();
    self::$_labels       = $this->getTLabels();
    self::$_placeholders = $this->getTPlaceholders();
    self::$_helps        = $this->getTHelps();
    self::$_attribs      = $this->getTAttribs();
    self::$table = Config::get('tablas.grados');
  }

  //==============
  public function getListSeccion($estado=null) {
    $DQL = "SELECT g.*, s.nombre AS seccion
            FROM ".self::$table." AS g
            LEFT JOIN ".Config::get('tablas.seccion')." AS s ON g.seccion_id=s.id";
    
    if (!is_null($estado)) {
      $DQL .= " WHERE (g.is_active=?) ORDER BY g.orden";
      return $this::all($DQL, array((int)$estado));
    }

    $DQL .= " ORDER BY g.orden";
    return $this::all($DQL);
  } // END-getList


    /**
     * Devuelve lista, limitando por estado y los campos a $select.
     */
    public function getList($estado=null, $select='*') {
      $DQL = "SELECT $select FROM ".self::$table;
      
      if (!is_null($estado)) {
      $DQL .= " WHERE (is_active=?) ORDER BY nombre ";
      return $this::all($DQL, array((int)$estado));
      }

      $DQL .= " ORDER BY nombre";
      return $this::all($DQL);
  } // END-getList

  
  /**
   * Devuelve lista de Secciones activas, limitando los campos a $select.
   */
  public function getListActivos(string $select='*'): array {
      return $this->getList(1, $select);
  }

  /**
   * Devuelve lista de Secciones Inactivas, limitando los campos a $select.
   * @return array
   * @example echo (new Seccion)->getListActivos();
   * @example echo (new Seccion)->getListActivos('id, nombre');
   */
  public function getListInactivos(string $select='*'): array {
      return $this->getList(0, $select);
  } 
  
}