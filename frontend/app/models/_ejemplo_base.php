<?php
/**
 * Modelo EjemploBase * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */
class EjemploBase extends LiteRecord
{
  use TraitUuid, EjemploBaseTraitCallBacks, EjemploBaseTraitDefa, EjemploBaseTraitProps,  EjemploBaseTraitLinksOlds;
  
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
    self::$table = Config::get('tablas.ejemplobase');
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
    $filas = EjemploBase::all();
    echo $filas[0]->id;

    // obtener un registro por su clave primaria
    $fila = EjemploBase::get($id);
    echo $fila->id;

    // obtener algunos registros como array según el filtro 
    $filas = EjemploBase::filter("WHERE nombre LIKE ?", [$nombreEjemploBase]);
    echo $filas[0]->id;

    //obtener registro según sql
    $fila = EjemploBase::first("SELECT * FROM self::$table WHERE nombre = :nombre", [":nombre" => $nombreEjemploBase]);
    echo $fila->id;

    // obtener array de algunos registros según sql
    $filas = EjemploBase::all("SELECT * FROM self::$table WHERE fecha_contrato >= ?", [$fecha]);
    echo $filas[0]->id;
  } 
  */

  /**
   * Crea un registro de la base de datos
   */
  /*
  public function createRegistro() {
    // #1: 
    $Objeto = new EjemploBase();
    $Objeto->create([
        'nombre' => 'Edgard Baptista',
        'cargo' => 'Contador',
        'fecha_contrato' => date('Y-m-d'),
        'activo' => 1
    ]); //Devuelve True o False

    // #2: 
    // por favor, prefiera este método por su simplicidad. 
    // save ejecuta el método create cuando falta la clave primaria y 
    // el de actualización cuando existe
    $Objeto = new EjemploBase();
    $Objeto->save([
        'nombre' => 'Edgard Baptista',
        'cargo' => 'Contador',
        'fecha_contrato' => date('Y-m-d'),
        'activo' => 1
    ]); //Devuelve True o False

    // #3: Metdo abreviado
    $Objeto = new EjemploBase([
        'nombre' => 'Edgard Baptista',
        'cargo' => 'Contador',
        'fecha_contrato' => date('Y-m-d'),
        'activo' => 1
    ]);
    $Objeto->save(); //Devuelve True o False
  }
  */

  /**
   * Edita un registro de la base de datos
   */
  /*
  public function editRegistro(int $id) {
    $Objeto = EjemploBase::get($id);

    $Objeto->update([
        'nombre' => 'Edgard Baptista',
        'activo' => 0
    ]); //Devuelve True o False

    // alternativa #2
    $Objeto->save([
        'nombre' => 'Edgard Baptista',
        'activo' => 0
    ]); //Devuelve True o False
  }
  */
  
  /**
   * Elimina un registro de la base de datos
   */
  /*
  public function deleteRegistro(int $id) {
    EjemploBase::delete($id); 
  }
  */

}