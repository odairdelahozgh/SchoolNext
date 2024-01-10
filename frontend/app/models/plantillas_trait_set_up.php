<?php
//require_once VENDOR_PATH.'autoload.php';

trait PlantillasTraitSetUp 
{  
  use TraitForms, PlantillasTraitProps;
  
  public function validar($input_post): bool 
  {
    Session::set(index: 'error_validacion', value: '');
    return true;
  }

  private function setUp(): void 
  {
    self::$_fields_show = [
      'all' => [
        `id`, `nombre`, `contenido`, `is_active`, `created_at`, `created_by`, `updated_at`, `updated_by`,
      ],
      'index'    => [
        `id`, `nombre`, `contenido`, `is_active`, `created_at`, `created_by`, `updated_at`, `updated_by`
      ],
      'create'   => [
        `nombre`, `contenido`, `is_active`
      ],
      'edit'     => [
        `id`, `nombre`, `contenido`, `is_active`
      ],
    ];
    
    self::$_labels = [
      'is_active'       => '¿Está Activo?',
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
    
    self::$_widgets = [
    ];

    self::$_attribs = [
    ];
  
    self::$_defaults = [
    ];
  
    self::$_helps = [
    ]; 
  
    self::$_placeholders = [
    ];
  }


}