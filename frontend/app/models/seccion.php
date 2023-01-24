<?php

/**
  * Modelo Seccion
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
*/
class Seccion extends LiteRecord
{
  // id, nombre, abrev, orden, is_active, color_text, color_bg
  // created_by, updated_by, created_at, updated_at
  protected static $table = 'sweb_secciones';
  public function __toString() { return $this->nombre; }


    /**
     * Devuelve lista de Secciones, limitando por estado y los campos a $select.
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
   * Devuelve lista de Secciones activas, limitando los campos a $select.
   * @return array
   * @example echo (new Seccion)->getListActivos();
   * @example echo (new Seccion)->getListActivos('id, nombre');
   */
  public function getListActivos(string $select='*'): array {
      return $this->getList(1, $select);
  }

  /**
   * Devuelve lista de Secciones activas, limitando los campos a $select.
   * @return array
   * @example echo (new Seccion)->getListActivos();
   * @example echo (new Seccion)->getListActivos('id, nombre');
   */
  public function getListInactivos(string $select='*'): array {
      return $this->getList(0, $select);
  }
  
}