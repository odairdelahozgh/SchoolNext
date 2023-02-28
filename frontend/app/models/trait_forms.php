<?php

trait TraitForms {
  /// PARA TODOS LO SMODELOS !!
  protected static $_fields_show = ['all'=>[], 'index'=>[], 'create'=>[1=>[], 2=>[]], 'edit'=>[1=>[], 2=>[]], 'editUuid'=>[1=>[], 2=>[]]];
  protected static $_attribs      = [];
  protected static $_widgets      = [];
  protected static $_defaults     = [];
  protected static $_helps        = [];
  protected static $_labels       = [];
  protected static $_placeholders = [];
  protected static $_rules_validators = [];
  // numeric, int, maxlength, length, range, select, email, url, ip, required, alphanum, alpha, date, pattern, decimal, equal

  public static function getDefault($field)     { return ((array_key_exists($field, self::$_defaults)) ? self::$_defaults[$field] : null); }
  public static function getLabel($field)       { return ((array_key_exists($field, self::$_labels)) ? self::$_labels[$field] : $field.': '); }
  public static function getPlaceholder($field) { return ((array_key_exists($field, self::$_placeholders)) ? self::$_placeholders[$field] : ''); }
  public static function getHelp($field)        { return ((array_key_exists($field, self::$_helps)) ? self::$_helps[$field]: ''); }
  public static function getAttrib($field)      { return ((array_key_exists($field, self::$_attribs)) ? self::$_attribs[$field]: ''); }
  public static function getWidget($field)      { return ((array_key_exists($field, self::$_widgets)) ? self::$_widgets[$field]: 'input'); }
  public static function getValidators($field)  { return ((array_key_exists($field, self::$_rules_validators)) ? self::$_rules_validators[$field]: ''); }
  
  public static function getFieldsShow(string $show='index', bool $show_labels = false): array {
    $srrShow = [];
    foreach (self::$_fields_show[$show] as $name => $field) {
      $srrShow[] = (($show_labels) ? self::getLabel($field) : $field);
    }
    return  $srrShow;
  }

  public static function getFieldsHidden(string $show='index'): array {
    return array_diff(self::$_fields_show['all'], self::$_fields_show[$show]);
  }

} //END-TraitForms