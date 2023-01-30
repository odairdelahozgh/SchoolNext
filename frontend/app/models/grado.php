<?php

/**
  * Modelo GRADO
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
    self::$table         = Config::get('tablas.grados');
    self::$class_name = __CLASS__;
    self::$order_by_default = 't.is_active DESC, t.orden';
  }

  //==============
  public function getListSeccion($estado=null) {
    $DQL = "SELECT g.*, s.nombre AS seccion
            FROM ".self::$table." AS g
            LEFT JOIN ".Config::get('tablas.secciones')." AS s ON g.seccion_id=s.id";
    
    if (!is_null($estado)) {
      $DQL .= " WHERE (g.is_active=?) ORDER BY g.orden";
      return $this::all($DQL, array((int)$estado));
    }

    $DQL .= " ORDER BY g.orden";
    return $this::all($DQL);
  } // END-getList

  /**
   * Devuelve lista de todos los Registros.
   */
  public function getList(int|bool $estado=null, string $select='*', string|bool $order_by=null) {
    $DQL = new OdaDql;
    $DQL->select($select)
        ->addSelect('s.nombre AS seccion')
        ->from(from_class: 'Grado')
        ->leftJoin('seccion', 's')
        ->orderBy(self::$order_by_default);
    if (!is_null($order_by)) { $DQL->orderBy($order_by); }
    if (!is_null($estado))   { $DQL->where('t.is_active=?'); }
    
    return $DQL->execute(true);
  }



}