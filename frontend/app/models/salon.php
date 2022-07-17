<?php

/**
  * Modelo Salon  
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
  */

class Salon extends LiteRecord
{
  use SalonT;
  protected static $table = 'sweb_salones';
  
  //=============
  public function getIsActiveF() {
    return (($this->is_active) ? '<i class="bi-check-circle-fill">' : '<i class="bi-x">');
  } // END-getIsActiveF

  
    /**
     * Retrona lista de Secciones, limitando por estado y los campos a $select.
     * @return array
     * @example echo (new Seccion)->getList();
     * @example echo (new Seccion)->getLists(1, 'id, nombre');
     */
    public function getList($estado=null, $select='*') {
      $DQL = "SELECT $select FROM ".self::$table;
      
      if (!is_null($estado)) {
      $DQL .= " WHERE (is_active=?) ORDER BY position ";
      return $this::all($DQL, array((int)$estado));
      }

      $DQL .= " ORDER BY position ";
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
   * Retrona lista de Secciones activas, limitando los campos a $select.
   * @return array
   * @example echo (new Seccion)->getListActivos();
   * @example echo (new Seccion)->getListActivos('id, nombre');
   */
  public function getListInactivos(string $select='*'): array {
      return $this->getList(0, $select);
  }
  

}