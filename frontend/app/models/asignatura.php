<?php
/**
 * Modelo Asignatura * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

 /* 
  // ->create(array $data = []): bool {}
  // ->update(array $data = []): bool {}
  // ->save(array $data = []): bool {}
  // ::delete($pk): bool
  //
  // ::get($pk, $fields = '*')
  // ::all(string $sql = '', array $values = []): array
  // ::first(string $sql, array $values = []): static
  // ::filter(string $sql, array $values = []): array

  // setActivar, setDesactivar
  // getById, deleteById, getList, getListActivos, getListInactivos
  // getByUUID, deleteByUUID, setUUID_All_ojo
*/

class Asignatura extends LiteRecord
{
  use TraitUuid, AsignaturaTraitCallBacks, AsignaturaTraitDefa, AsignaturaTraitProps,  AsignaturaTraitLinksOlds;
  
  // Para debuguear: debug, warning, error, alert, critical, notice, info, emergence
  // OdaLog::debug(msg: "Mensaje", name_log:'nombre_log'); 
  
  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.asignatura');
    self::$_defaults     = $this->getTDefaults();
    self::$_labels       = $this->getTLabels();
    self::$_placeholders = $this->getTPlaceholders();
    self::$_helps        = $this->getTHelps();
    self::$_attribs      = $this->getTAttribs();
    self::$class_name = __CLASS__;
    self::$order_by_default = 'nombre ASC';
  } //END-__construct


} //END-CLASS