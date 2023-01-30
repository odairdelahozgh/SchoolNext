/**
 * Modelo <?=$class?>
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
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
*/

class <?=$class?> extends LiteRecord
{
  use TraitUuid, <?=$class?>TraitCallBacks, <?=$class?>TraitDefa, <?=$class?>TraitProps,  <?=$class?>TraitLinksOlds;
  
  // Para debuguear: debug, warning, error, alert, critical, notice, info, emergence
  // OdaLog::debug(msg: "Mensaje", name_log:'nombre_log'); 
  
  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.<?=strtolower($class)?>');
    self::$_defaults     = $this->getTDefaults();
    self::$_labels       = $this->getTLabels();
    self::$_placeholders = $this->getTPlaceholders();
    self::$_helps        = $this->getTHelps();
    self::$_attribs      = $this->getTAttribs();
    self::$class_name = __CLASS__;
    //self::$order_by_default = 'nombre ASC';
  } //END-__construct


} //END-CLASS