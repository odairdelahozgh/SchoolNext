<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait AreaTraitSetUp {
  
  use TraitUuid, TraitForms;

  public function __toString() { return $this->nombre; }
  

  public function validar($input_post) {
    Session::set('error_validacion', '');
    try{
      validar::number()->length(1)->min(0)->max(1)->assert($input_post['is_active']);
      validar::number()->assert($input_post['orden']);
      validar::alpha()->assert($input_post['nombre']);
      return true;
    } catch(NestedValidationException $exception) {
      Session::set('error_validacion', $exception->getFullMessage());
      return false;
    }
  } //END-validar


  /**
   * CONFIGURACIÓN DEL MODELO
   */
  private function setUp() {

    self::$_fields_show = [
      'all'      => ['id', 'uuid', 'nombre', 'orden', 'created_at', 'updated_at', 'created_by', 'updated_by', 'is_active'],
      'index'    => ['is_active', 'nombre', 'orden', 'updated_at'],
      'create'   => ['nombre', 'orden'],
      'edit'     => ['nombre', 'orden', 'is_active'],
      'editUuid' => ['nombre', 'orden', 'is_active'],
    ];
  
    self::$_attribs = [
      'nombre'       => 'required',
      'orden'        => 'required',
    ];
  
    self::$_defaults = [
      'nombre'          => '',
      'orden'           => 0,
      'is_active'       => 1,
    ];
  
    self::$_helps = [
      'is_active'    => 'Indica si está activo el registro.',
    ];
  
    self::$_labels = [
      'nombre'          => 'Area',
      'orden'           => 'Orden',

      'id'              => 'ID',
      'uuid'            => 'UUID',
      'is_active'       => 'Está Activo? ',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
      'nombre'          => 'nombre del area',
      'orden'           => 'ordenamiento interno',
    ];
  
    // numeric, int, maxlength, length, range, select, email, url, ip, required, alphanum, alpha, date, pattern, decimal, equal
    self::$_rules_validators = [
      'nombre' => [
        'required' => [ 'error' => 'es requerido.' ],
        'alpha'    => [ 'error' => 'debe contener solo letras.' ],
      ],
      'orden'  => [
        'required' => [ 'error' => 'es requerido.' ],
        'int'      => [ 'error' => 'debe contener solo numeros enteros.' ],
      ],
    ];

  }
} //END-SetUp