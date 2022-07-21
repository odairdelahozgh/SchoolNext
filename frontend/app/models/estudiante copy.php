<?php

//use Kumbia\ActiveRecord\LiteRecord;
//use Kumbia\ActiveRecord\ActiveRecord;

/**
  * Modelo Estudiante  
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
  */

class Estudiante extends LiteRecord
{
  protected static $table = 'sweb_estudiantes';
  
  //---------
  protected static $_defaults = array();
  protected static $_labels = array();
  protected static $_placeholders = array();
  protected static $_helps = array();
  public function getDefault($field) { return ((array_key_exists($field, self::$_defaults)) ? self::$_defaults[$field] : null); }
  public function getLabel($field) { return ((array_key_exists($field, self::$_labels)) ? self::$_labels[$field] : $field.': '); }
  public function getPlaceholder($field) { return ((array_key_exists($field, self::$_placeholders)) ? self::$_placeholders[$field] : ''); }
  public function getHelp($field) { return ((array_key_exists($field, self::$_placeholders)) ? self::$_helps[$field]: ''); }

  /*  CALLBACKS:
  before_validation, before_validation_on_create, before_save, before_update, before_validation_on_update, before_create
  after_validation, after_validation_on_create, after_validation_on_update, after_create, after_update, after_save
  before_delete, after_delete */

  public $before_delete = 'no_borrar_activos';
  public function no_borrar_activos() {
    if($this->is_active==1) {
      OdaFlash::error('No se puede borrar un registro activo', __CLASS__);
      return 'cancel';
    }
  }

  public function after_delete() {
    OdaFlash::valid('Se borró el registro');
  }

  public function before_create() { 
    $this->is_active = 1; 
  }

  /**
    * Retorna TODOS los registros del modelo Estudiante sin paginación
    */
  public function getList() {
    return (new Estudiante)->all();
  }

  /**
    * Retorna los registros ACTIVOS del modelo Estudiante para ser paginados
    * @param int $page  [requerido] página a visualizar
    * @param int $ppage [opcional] por defecto 20 por página
    */
  public function getEstudiantes($page, $ppage=20) {
    //return $this->paginate(array(), $page, $ppage, null);
  }

    
  /**
    * Método mágico de objeto
    */
  public function __toString() {
    return $this->id.': ' .$this->getNombreCompleto();
  }
  
  //=========
  public function getNombreCompleto($orden='a1 a2, n') {
    return str_replace(
          array('n', 'a1', 'a2'),
          array($this->nombres, $this->apellido1, $this->apellido2),
          $orden
      );
  }
  //=========
  public function getIsActiveF() {
    return (($this->is_active) ? '<i class="bi-check-circle-fill">' : '<i class="bi-x">');
  }

  //=========
  public function getCuentaInstit(){
    return ($this->email_instit) ? $this->email_instit.'@windsorschool.edu.co'.'<br/>'.$this->clave_instit : '';
  }



}