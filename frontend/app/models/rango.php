<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

include "rango/rango_trait_set_up.php";

class Rango extends LiteRecord {

  use RangoTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.rango');
    $this->setUp();
  }

  /**
   * @deprecated
   */
  protected static $aRangos = [
    '1-59'   => 'Bajo',
    '60-69'  => 'Básico',
    '61-79'  => 'Básico +',
    '80-89'  => 'Alto',
    '90-94'  => 'Alto +',
    '95-100' => 'Superior',
  ];
  
  /**
   * @deprecated
   */
  protected static $aRangosColores = [
    'Bajo'     => 'w3-red',
    'Básico'   => 'w3-orange',
    'Básico +' => 'w3-yellow',
    'Alto'     => 'w3-light-blue',
    'Alto +'   => 'w3-blue',
    'Superior' => 'w3-green',
  ];
  
  /**
   * @deprecated
   */
  protected static $aRangosLimiteInf = [
    '1'  => 'Bajo',
    '60' => 'Básico',
    '70' => 'Básico +',
    '80' => 'Alto',
    '90' => 'Alto +',
    '95' => 'Superior',
  ];


  public static function getRango($valor=0): string 
  {
    if ($valor==0)  { 
      return ''; 
    }

    if ($valor<0)   { 
      return _Icons::solid('face-frown', 'w3-large').'Rango no válido: Inferior a Cero';
    }

    if ($valor>100) { 
      return _Icons::solid('face-frown', 'w3-large').'Rango no válido: Superior a 100';
    }

    $result = '';
    foreach (self::$aRangos as $key => $rango) {
      $aPartes = explode(separator: '-', string: $key);
      if ( ($valor>=$aPartes[0]) && ($valor<=$aPartes[1]) ) {
        $result = $rango;
        break;
      }
    }
    return $result;
  }
  
  
  public static function getColorRango($valor=0): string 
  {
    $rango = self::getRango($valor);

    if (array_key_exists($rango, self::$aRangosColores)) {
      return self::$aRangosColores[$rango];
    }

    return 'w3-aqua w3-border-theme';
  }
  


}