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
  protected static $table = 'sweb_grados';
  
  //=========
    const SECCIONES = [
      1 => 'Prescolar',
      2 => 'Básica Primaria',
      3 => 'Básica Secundaria',
      4 => 'Media Académica',
  ];

  public function __construct() {
    
    $user_id = Session::get('id');

    self::$_defaults = array(
      'is_active'          => 1,
      'orden'              => 1,
      'nombre'             => '',
      'abrev'              => '',
      'seccion_id'         => 1,
      'salon_default'      => 1,
      'valor_matricula'    => 100000,
      'matricula_palabras' => '',
      'valor_pension'      => 100000,
      'pension_palabras'   => '',
      'proximo_grado'      => 1,
      'proximo_salon'      => 1,
      'created_by'         => $user_id,
      'updated_by'         => $user_id,
      'created_at'         => date('Y-m-d H:i:s', time()),
      'updated_at'         => date('Y-m-d H:i:s', time()),
    );
    
    self::$_labels = array(
      'is_active'          => 'Está Activo?',
      'orden'              => 'Orden',
      'nombre'             => '** Nombre del Grado',
      'abrev'              => 'Abreviatura',
      'seccion_id'         => 'Sección',
      'salon_default'      => 'Salón por defecto',
      'valor_matricula'    => 'Valor Matrícula',
      'matricula_palabras' => 'Valor Matrícula en palabras',
      'valor_pension'      => 'Valor Pensión',
      'pension_palabras'   => 'Valor Pensión en palabras',
      'proximo_grado'      => 'Próximo Grado',
      'proximo_salon'      => 'Próximo Salon',
      'created_by'         => 'Creado por',
      'updated_by'         => 'Actualizado por',
      'created_at'         => 'Creado a',
      'updated_at'         => 'Actualizado a',
    );
    
    self::$_placeholders = array(
      'is_active'          => '',
      'orden'              => '',
      'nombre'             => 'Nombre del Grado',
      'abrev'              => 'Abreviatura para el Grado',
      'seccion_id'         => 'Sección',
      'salon_default'      => '',
      'valor_matricula'    => '',
      'matricula_palabras' => 'Valor matrícula en palabras',
      'valor_pension'      => '',
      'pension_palabras'   => 'Valor pensión en palabras',
      'proximo_grado'      => '',
      'proximo_salon'      => '',
      'created_by'         => '',
      'updated_by'         => '',
      'created_at'         => '',
      'updated_at'         => '',
    );

    
    self::$_helps = array(
      'is_active'          => 'Indica si está activo el registro.',
      'orden'              => 'Orden en el que se muestra en los listados.',
      'nombre'             => 'Máximo 50 caracteres.',
      'abrev'              => 'Máximo 10 caracteres.',
      'seccion_id'         => 'Elija una opción.',
      'salon_default'      => 'Salón por default.',
      'valor_matricula'    => 'Número sin puntos, ni comas, ni tildes.',
      'matricula_palabras' => 'to-do: hidden, hacer en automático',
      'valor_pension'      => 'Número sin puntos, ni comas, ni tildes.',
      'pension_palabras'   => 'to-do: hidden, hacer en automático',
      'proximo_grado'      => 'Próximo grado al promoverse.',
      'proximo_salon'      => 'Próximo salón al promoverse.',
      'created_by'         => '',
      'updated_by'         => '',
      'created_at'         => '',
      'updated_at'         => '',
    );
    
    
    self::$_attribs = array(
      'is_active'          => '',
      'orden'              => '',
      'nombre'             => 'required="required" maxlength="50"',
      'abrev'              => 'maxlength="10"',
      'seccion_id'         => '',
      'salon_default'      => '',
      'valor_matricula'    => '',
      //'matricula_palabras' => '',
      'valor_pension'      => '',
      //'pension_palabras'   => '',
      'proximo_grado'      => '',
      'proximo_salon'      => '',
      //'created_by'         => '',
      //'updated_by'         => '',
      //'created_at'         => '',
      //'updated_at'         => '',
    );

  }
  
  public function _beforeUpdate() {
  }

  public function _beforeCreate() { // Antes de Crear el nuevo registro
    $user_id = Session::get('id');
    $ahora = $this::now();
    
    $this->uuid = $this->uniqidReal(20);
    $this->created_by = $user_id;
    $this->updated_by = $user_id;
    $this->created_at = $ahora;
    $this->updated_at = $ahora;
    $this->is_active = 1;
    $this->abrev = strtoupper($this->abrev);
    $this->matricula_palabras = strtolower(OdaUtils::getNumeroALetras($this->valor_matricula));
    $this->pension_palabras = strtolower(OdaUtils::getNumeroALetras($this->valor_pension));
  }
  
  public function _afterCreate() { }

  public function _afterUpdate() { }
  
  

    
  //==============
  public function getList($estado=null) {
    if (is_null($estado)) { // todos
      $DQL = "SELECT g.*, s.nombre AS seccion
      FROM ".self::$table." AS g
      LEFT JOIN ".Config::get('tablas.seccion')." AS s ON g.seccion_id=s.id
      ORDER BY g.orden";
      return $this::all($DQL);
    } else { // filtro por estado
      $DQL = "SELECT g.*, s.nombre AS seccion
      FROM ".self::$table." AS g
      LEFT JOIN ".Config::get('tablas.seccion')." AS s ON g.seccion_id=s.id
      WHERE (g.is_active=?)
      ORDER BY g.orden";
      return $this::all($DQL, array((int)$estado));
    }

  } // END-getList
  

  //=========
  public function __toString() {
    return $this->nombre;
  } // END-toString

  

}