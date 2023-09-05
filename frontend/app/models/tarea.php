<?php
/**
 * Modelo Tarea
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * 'id', 'uuid', 'modulo', 'seccion', 'nombre', 'descripcion', 'prioridad', 'fecha_ini', 'fecha_fin', 'estado', 'avance', 'is_active', 'created_at', 'created_by', 'updated_at', 'updated_by'
 */
  
class Tarea extends LiteRecord {

  use TareaTraitSetUp;
  
  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.tareas');
    self::$_order_by_defa = 't.estado, t.prioridad, t.avance, t.nombre';
    $this->setUp();
  } //END-__construct


} //END-CLASS