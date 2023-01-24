<?php
/**
 * Modelo Usuario * 
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

  /*
  id, uuid, username, roll, is_active, is_carga_acad_ok, documento, email, algorithm, salt, password, is_super_admin, 
  last_login, forgot_password_code, created_at, updated_at, nombres, apellido1, apellido2, photo, profesion, direccion, 
  telefono1, telefono2, cargo, sexo, fecha_nac, fecha_ing, fecha_ret, observacion, is_partner, 
  usuario_instit, clave_instit, theme
 */

class Usuario extends LiteRecord
{
  use TraitUuid, UsuarioTraitCallBacks, UsuarioTraitDefa, UsuarioTraitProps;
  
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
    self::$table = Config::get('tablas.usuario');
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
    $filas = Usuario::all();
    echo $filas[0]->id;

    // obtener un registro por su clave primaria
    $fila = Usuario::get($id);
    echo $fila->id;

    // obtener algunos registros como array según el filtro 
    $filas = Usuario::filter("WHERE nombre LIKE ?", [$nombreUsuario]);
    echo $filas[0]->id;

    //obtener registro según sql
    $fila = Usuario::first("SELECT * FROM self::$table WHERE nombre = :nombre", [":nombre" => $nombreUsuario]);
    echo $fila->id;

    // obtener array de algunos registros según sql
    $filas = Usuario::all("SELECT * FROM self::$table WHERE fecha_contrato >= ?", [$fecha]);
    echo $filas[0]->id;
  } 
  */

  /**
   * Crea un registro de la base de datos
   */
  /*
  public function createRegistro() {
    // #1: 
    $Objeto = new Usuario();
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
    $Objeto = new Usuario();
    $Objeto->save([
        'nombre' => 'Edgard Baptista',
        'cargo' => 'Contador',
        'fecha_contrato' => date('Y-m-d'),
        'activo' => 1
    ]); //Devuelve True o False

    // #3: Metdo abreviado
    $Objeto = new Usuario([
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
    $Objeto = Usuario::get($id);

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
    Usuario::delete($id); 
  }
  */

}