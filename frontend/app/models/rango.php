<?php
/**
 * Modelo Rango * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

/* 
  'id', 'nombre', 'lim_inf', 'lim_sup', 'color_rango', 'color_texto', 'color_backg', 
  'created_by', 'updated_by', 'created_at', 'updated_at'
*/
  
class Rango extends LiteRecord {

  use RangoTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get(var: 'tablas.rango');
    $this->setUp();
  } //END-__construct

  protected static $aRangos = array(
    '1-59'   => 'Bajo',
    '60-69'  => 'Básico',
    '61-79'  => 'Básico +',
    '80-89'  => 'Alto',
    '90-94'  => 'Alto +',
    '95-100' => 'Superior',
  );//aRangos
  protected static $aRangosColores = array(
    'Bajo'     => 'red',
    'Básico'   => 'orange',
    'Básico +' => 'yellow',
    'Alto'     => 'light-blue',
    'Alto +'   => 'blue',
    'Superior' => 'green',
  );//aRangosColores
  protected static $aRangosLimiteInf = array(
    '1'  => 'Bajo',
    '60' => 'Básico',
    '70' => 'Básico +',
    '80' => 'Alto',
    '90' => 'Alto +',
    '95' => 'Superior',
  );//aRangosLimiteInf

  public static function getRango($valor=0): string {
    if ($valor==0)  { return ''; }
    if ($valor<0)   { return _Icons::solid(icon: 'face-frown',size: 'w3-large').'Rango no válido: Inferior a Cero'; }
    if ($valor>100) { return _Icons::solid(icon: 'face-frown',size: 'w3-large').'Rango no válido: Superior a 100'; }
    foreach (self::$aRangos as $key => $rango) {
      $aPartes = explode(separator: '-', string: $key);
      if ( ($valor>=$aPartes[0]) && ($valor<=$aPartes[1]) ) {
        return $rango;
      }
    }
  } //END-getRango
  
  //====================
  public static function getColorRango($valor=0): string  {
    $rango = self::getRango(valor: $valor);
    if (array_key_exists(key: $rango, array: self::$aRangosColores)) {
      return self::$aRangosColores[$rango];
    } else {
      return 'w3-aqua w3-border-theme';
    }
  } //END-getColorRango


} //END-CLASS