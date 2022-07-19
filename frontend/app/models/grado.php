<?php

/**
  * Modelo GRADO
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
  *  campos: id, uuid, is_active, orden, nombre, abrev, seccion_id, 
  *  proximo_grado, salon_default, 
  *  valor_matricula, matricula_palabras, valor_pension, pension_palabras, proximo_salon, 
  *  created_by, updated_by, created_at, updated_at
  */
class Grado extends LiteRecord
{
  use GradoT;
  protected static $table = 'sweb_grados';

  public function __construct() {
    self::$_defaults     = $this->getTDefaults();
    self::$_labels       = $this->getTLabels();
    self::$_placeholders = $this->getTPlaceholders();
    self::$_helps        = $this->getTHelps();
    self::$_attribs      = $this->getTAttribs();
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
     * Retrona lista de Secciones, limitando por estado y los campos a $select.
     * @return array
     * @example echo (new Seccion)->getList();
     * @example echo (new Seccion)->getLists(1, 'id, nombre');
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
   * Retrona lista de Secciones activas, limitando los campos a $select.
   * @return array
   * @example echo (new Seccion)->getListActivos();
   * @example echo (new Seccion)->getListActivos('id, nombre');
   */
  public function getListActivos(string $select='*'): array {
      return $this->getList(1, $select);
  }

  /**
   * Retrona lista de Secciones Inactivas, limitando los campos a $select.
   * @return array
   * @example echo (new Seccion)->getListActivos();
   * @example echo (new Seccion)->getListActivos('id, nombre');
   */
  public function getListInactivos(string $select='*'): array {
      return $this->getList(0, $select);
  } 
  
}