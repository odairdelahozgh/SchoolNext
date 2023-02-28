<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait EmpleadoTraitSetUp {
  
  use TraitUuid, TraitForms;
  
  public function validar($input_post) {
    Session::set('error_validacion', '');
    try{
      validar::alnum()->noWhitespace()->length(3, 20)->assert($input_post['username']);
      validar::email()->assert($input_post['email']);
      validar::number()->length(1)->min(0)->max(1)->assert($input_post['is_active']);
      return true;
    } catch(NestedValidationException $exception) {
      Session::set('error_validacion', $exception->getFullMessage());
      return false;
    }
  } //END-validar

/* 
* id, uuid, username, roll, nombres, apellido1, apellido2, photo, profesion, direccion, documento, email, 
* telefono1, telefono2, cargo, sexo, fecha_nac, fecha_ing, fecha_ret, observacion, is_carga_acad_ok, 
* is_partner, usuario_instit, clave_instit, theme, 
* algorithm, salt, password, is_super_admin, last_login, forgot_password_code, 
* is_active, created_at, updated_at,  
*/
  
  /**
   * CONFIGURACIÓN DEL MODELO
   */
  private function setUp() {

    self::$_fields_show = [
      'all'       => ['id', 'uuid', 'username', 'roll', 'nombres', 'apellido1', 'apellido2', 'photo', 'profesion', 'direccion', 'documento', 'email', 'telefono1', 'telefono2', 'cargo', 'sexo', 'fecha_nac', 'fecha_ing', 'fecha_ret', 'observacion', 'is_carga_acad_ok', 'is_partner', 'usuario_instit', 'clave_instit', 'theme', 'algorithm', 'salt', 'password', 'is_super_admin', 'last_login', 'forgot_password_code', 'is_active', 'created_at', 'updated_at'],
      'index'     => ['is_active', 'nombre', 'username', 'roll', 'documento','usuario_instit', 'clave_instit'],
      'create'    => [],
      'edit'      => [],
      'editUuid'  => [],
    ];
  
    self::$_attribs = [
      'id'       => 'required',
      'uuid'     => 'required',
    ];
  
    self::$_defaults = [
      'is_active'       => 1,
    ];
  
    self::$_helps = [
      'fecha_nac'          => 'dd/mm/aaaa - Ejemplo: 26/07/1976',
      'documento'          => 'Advertencia!! sin puntos, sin comas.',
      
      'is_active'    => 'Indica si está activo el registro.',
    ];
  
    self::$_labels = [
      'nombre'          => 'Nombre Empleado',
      'username'        => 'Nombre de Usuario',
      'roll'            => 'Roles',
      'usuario_instit'  => 'Usuario TEAMS',
      'clave_instit'    => 'Clave TEAMS',

      'nombres'    => 'Nombre(s)',
      'apellido1'  => 'Primer Apellido',
      'apellido2'  => 'Segundo Apellido',
      'fecha_nac'  => 'Fecha Nacimiento',
      
      'direccion'  => 'Dirección',
      'cargo'      => 'Cargo',
      'fecha_nac'  => 'Fecha Nacimiento',
      'documento'  => 'Documento',
      'telefono1'  => 'Teléfono Principal',
      'telefono2'  => 'Teléfono Secundario',
      'sexo'       => 'Sexo',
      
      'profesion'         => 'Profesión',
      'is_carga_acad_ok'  => 'Carga Académicas',
      
      'is_active'       => 'Estado',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
    ];

  }
} //END-SetUp