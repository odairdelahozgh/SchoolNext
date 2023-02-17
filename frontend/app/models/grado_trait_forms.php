<?php
trait GradoTraitForms {

  public static $_fields_show = [
    'all'  => ['id', 'nombre', 'created_at', 'updated_at', 'is_active'],
    'list' => ['id', 'nombre', 'created_at', 'updated_at', 'is_active'],
    'form_new'  => ['nombre'],
    'form_edit' => ['id', 'nombre', 'is_active']
  ];

  protected static $_attribs = [
    'is_active'         => '',
    'created_by'        => '',
    'updated_by'        => '',
    'created_at'        => '',
    'updated_at'        => '',
  ];

  protected static $_defaults = [
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
  ];

  protected static $_helps = [
    'is_active'          => 'Indica si está activo el registro.',
    'created_by'         => 'Creado por:',
    'updated_by'         => 'Actualizado por',
    //'created_at'         => '',
    //'updated_at'         => '',
  ];

  protected static $_labels = [
    'is_active'          => 'Está Activo? ',
    'created_at'         => 'Creado el: ',
    'created_by'         => 'Creado por: ',
    'updated_at'         => 'Actualizado el: ',
    'updated_by'         => 'Actualizado por: ',
  ];

  protected static $_placeholders = [
    //'is_active'          => '',
    //'created_by'         => '',
    //'updated_by'         => '',
    //'created_at'         => '',
    //'updated_at'         => '',
  ];

  // numeric, int, maxlength, length, range, select, email, url, ip, required, alphanum, alpha, date, pattern, decimal, equal
  protected static $_rules_validators = [
    'nombre' => [
      'required'   => [ 'error' => 'es requerido.' ],
      'alpha'      => [ 'error' => 'debe contener solo letras.' ],
      'maxlength'  => [ 'error' => 'sobre pasa la longitud maxima del campo.' ],
    ],
  ];

  public function getDefault($field)     { return ((array_key_exists($field, self::$_defaults)) ? self::$_defaults[$field] : null); }
  public function getLabel($field)       { return ((array_key_exists($field, self::$_labels)) ? self::$_labels[$field] : $field.': '); }
  public function getPlaceholder($field) { return ((array_key_exists($field, self::$_placeholders)) ? self::$_placeholders[$field] : ''); }
  public function getHelp($field)        { return ((array_key_exists($field, self::$_helps)) ? self::$_helps[$field]: ''); }
  public function getAttrib($field)      { return ((array_key_exists($field, self::$_attribs)) ? self::$_attribs[$field]: ''); }
  public function getValidators($field)  { return ((array_key_exists($field, self::$_rules_validators)) ? self::$_rules_validators[$field]: ''); }

} //END-TraitForms