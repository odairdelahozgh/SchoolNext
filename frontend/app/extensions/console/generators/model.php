/**
 * Modelo <?=$class?>
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
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

class <?=$class?> extends LiteRecord
{
  use TraitUuid, <?=$class?>TraitCallBacks, <?=$class?>TraitDefa, <?=$class?>TraitProps,  <?=$class?>TraitLinksOlds;
  
  // Para debuguear
  // OdaLog::debug(msg: "Mensaje", name_log:'nombre_log'); // debug, warning, error, alert, critical, notice, info, emergence
  // OdaLog::debug(type: "nombre_typo", msg: "Mensaje", name_log:'nombre_log');
  
  // OdaUtils
  // [Util] camelcase, smallcase, underscore, dash, humanize, getParams, encomillar
  // ver_array, nombreMes, nombreGenero, randomString, truncate, nombrePersona
  // sanearString, getIp, isLocalhost, resaltar, getSlug, orderArray, pluralize
  // getNumeroALetras
  
  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.<?=strtolower($class)?>');
    self::$_defaults     = $this->getTDefaults();
    self::$_labels       = $this->getTLabels();
    self::$_placeholders = $this->getTPlaceholders();
    self::$_helps        = $this->getTHelps();
    self::$_attribs      = $this->getTAttribs();
  }

  /**
   * Filtra registro(s) de la base de datos
   */
  /*
  public function filtrar(int $id){
    // obtener todos los registros como array
    $filas = <?=$class?>::all();
    echo $filas[0]->id;

    // obtener un registro por su clave primaria
    $fila = <?=$class?>::get($id);
    echo $fila->id;

    // obtener algunos registros como array según el filtro 
    $filas = <?=$class?>::filter("WHERE nombre LIKE ?", [$nombre<?=$class?>]);
    echo $filas[0]->id;

    //obtener registro según sql
    $fila = <?=$class?>::first("SELECT * FROM self::$table WHERE nombre = :nombre", [":nombre" => $nombre<?=$class?>]);
    echo $fila->id;

    // obtener array de algunos registros según sql
    $filas = <?=$class?>::all("SELECT * FROM self::$table WHERE fecha_contrato >= ?", [$fecha]);
    echo $filas[0]->id;
  } 
  */

  /**
   * Crea un registro de la base de datos
   */
  /*
  public function createRegistro() {
    // #1: 
    $Objeto = new <?=$class?>();
    $Objeto->create([
        'nombre' => 'Edgard Baptista',
        'cargo' => 'Contador',
        'fecha_contrato' => date('Y-m-d'),
        'activo' => 1
    ]); //retorna True o False

    // #2: 
    // por favor, prefiera este método por su simplicidad. 
    // save ejecuta el método create cuando falta la clave primaria y 
    // el de actualización cuando existe
    $Objeto = new <?=$class?>();
    $Objeto->save([
        'nombre' => 'Edgard Baptista',
        'cargo' => 'Contador',
        'fecha_contrato' => date('Y-m-d'),
        'activo' => 1
    ]); //retorna True o False

    // #3: Metdo abreviado
    $Objeto = new <?=$class?>([
        'nombre' => 'Edgard Baptista',
        'cargo' => 'Contador',
        'fecha_contrato' => date('Y-m-d'),
        'activo' => 1
    ]);
    $Objeto->save(); //retorna True o False
  }
  */

  /**
   * Edita un registro de la base de datos
   */
  /*
  public function editRegistro(int $id) {
    $Objeto = <?=$class?>::get($id);

    $Objeto->update([
        'nombre' => 'Edgard Baptista',
        'activo' => 0
    ]); //retorna True o False

    // alternativa #2
    $Objeto->save([
        'nombre' => 'Edgard Baptista',
        'activo' => 0
    ]); //retorna True o False
  }
  */
  
  /**
   * Elimina un registro de la base de datos
   */
  /*
  public function deleteRegistro(int $id) {
    <?=$class?>::delete($id); 
  }
  */

}