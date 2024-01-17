<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait UsuarioTraitSetUp {
  
  use TraitUuid, TraitForms, UsuarioTraitProps;
  
  public function validar($input_post) 
  {
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
  }
  

  private function setUp() 
  {
    self::$_fields_show['all']      = ['id', 'uuid', 'username', 'roll', 'nombres', 'apellido1', 'apellido2', 'photo', 'profesion', 'direccion', 'documento', 'email', 'telefono1', 'telefono2', 'cargo', 'sexo', 'fecha_nac', 'fecha_ing', 'fecha_ret', 'observacion', 'is_carga_acad_ok', 'is_partner', 'usuario_instit', 'clave_instit', 'theme', 'algorithm', 'salt', 'password', 'is_super_admin', 'last_login', 'forgot_password_code', 'is_active', 'created_at', 'updated_at'];
    self::$_fields_show['index']    = ['is_active', 'id', 'username', 'roll', 'nombres', 'apellido1', 'apellido2', 'documento','usuario_instit', 'clave_instit'];
    self::$_fields_show['create']   = ['username', 'roll', 'nombres', 'apellido1', 'apellido2', 'documento', 'email', 'direccion', 'telefono1', 'telefono2', 'fecha_nac', 'fecha_ing', 'fecha_ret', 'usuario_instit', 'clave_instit', 'theme', 'is_active', 'algorithm' ];
    self::$_fields_show['edit']     = ['username', 'roll', 'nombres', 'apellido1', 'apellido2', 'documento', 'email', 'direccion', 'telefono1', 'telefono2', 'fecha_nac', 'fecha_ing', 'fecha_ret', 'usuario_instit', 'clave_instit', 'theme', 'is_active', 'algorithm', 'uuid' ];
    self::$_fields_show['editUuid'] = ['username', 'roll', 'nombres', 'apellido1', 'apellido2', 'documento', 'email', 'direccion', 'telefono1', 'telefono2', 'fecha_nac', 'fecha_ing', 'fecha_ret', 'usuario_instit', 'clave_instit', 'theme', 'is_active', 'algorithm', 'uuid' ];
  
    self::$_attribs = [
      'id'  => 'required',
      'uuid'  => 'required',
    ];
  
    self::$_defaults = [
      'is_active' => 1,
    ];
  
    self::$_helps = [
      'fecha_nac' => 'dd/mm/aaaa - Ejemplo: 26/07/1976',
      'documento' => 'Advertencia!! sin puntos, sin comas.',
      'is_active' => 'Indica si está activo el registro.',
    ];
  
    self::$_labels = [
      'username'  => 'Nombre de Usuario:',
      'roll'  => 'Roles de Usuario:',

      'nombres' => 'Nombre(s):',
      'apellido1' => 'Primer Apellido:',
      'apellido2' => 'Segundo Apellido:',
      'fecha_nac' => 'Fecha Nacimiento:',
      
      'direccion' => 'Dirección:',
      'cargo' => 'Cargo:',
      'documento' => 'Nro. Documento:',
      'telefono1' => 'Teléfono Principal:',
      'telefono2' => 'Teléfono Secundario:',
      'sexo'  => 'Sexo:',
      
      'profesion' => 'Profesión:',
      'is_carga_acad_ok'  => 'Carga Académicas:',
      
      'is_active' => 'Está Activo? ',
      'created_at'  => 'Creado el',
      'created_by'  => 'Creado por',
      'updated_at'  => 'Actualizado el',
      'updated_by'  => 'Actualizado por',
    ];
  
    self::$_placeholders = [
    ];
  
    // numeric, int, maxlength, length, range, select, email, url, ip, required, alphanum, alpha, date, pattern, decimal, equal
    self::$_rules_validators = [
        /*
        'NombreCompleto' => [
				  'required' => [ 'error' => 'Indique su nombre.' ],
				  'alpha'    => [ 'error' => 'Nombre incompleto o incorrecto.' ]
			  ],
			  'Email' => [
				  'required' => [ 'error' => 'Indique su email.' ],
				  'email'    => [ 'error' => 'Email incorrecto.' ]
			  ],
			  'Movil' => [
				  'required' => [ 'error' => 'Indique su teléfono / móvil.' ],
				  'length'   => [ 'min' => '9', 'max' => '17', 'error' => 'Teléfono / móvil incorrecto' ],
          'pattern'  => [ 'regexp' => '/^\+(?:[0-9] ?){6,14}[0-9]$/', 'error'  => 'Teléfono incorrecto. ejemplo. +34 862929929']
        ], 
        */
    ];
  }


}