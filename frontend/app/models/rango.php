<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

include "rango/rango_trait_set_up.php";

#[AllowDynamicProperties]
class Rango extends LiteRecord {

  use RangoTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$pk    = 'rowid';
    self::$table = Config::get('tablas.rango');
    $this->setUp();
  }

  /**
   * @deprecated
   */
  protected static $aRangos = 
  [
    'windsor' => [
      '1-59'   => 'Bajo',
      '60-79'  => 'Básico',
      '80-94'  => 'Alto',
      '95-100' => 'Superior',
    ],

    'santarosa' => [
      '1-29'   => 'Bajo',
      '30-37'  => 'Básico',
      '38-44'  => 'Alto',
      '45-50' => 'Superior',
    ],

    'development' => [
      '1-29'   => 'Bajo',
      '30-37'  => 'Básico',
      '38-44'  => 'Alto',
      '45-50' => 'Superior',
    ],

  ];
  
  /**
   * @deprecated
   */
  protected static $aRangosColores = 
  [
    'windsor' => [
      'Bajo'     => 'w3-red',
      'Básico'   => 'w3-orange',
      'Alto'     => 'w3-light-blue',
      'Superior' => 'w3-green',
    ],

    'santarosa' => [
      'Bajo'     => 'w3-red',
      'Básico'   => 'w3-orange',
      'Alto'     => 'w3-light-blue',
      'Superior' => 'w3-green',
    ],

    'development' => [
      'Bajo'     => 'w3-red',
      'Básico'   => 'w3-orange',
      'Alto'     => 'w3-light-blue',
      'Superior' => 'w3-green',
    ],

  ];
  
  /**
   * @deprecated
   */
  protected static $aRangosLimiteInf = [
    'windsor'=> [
      '1'  => 'Bajo',
      '60' => 'Básico',
      '80' => 'Alto',
      '95' => 'Superior',
    ],

    'santarosa'=> [
      '1'  => 'Bajo',
      '30' => 'Básico',
      '38' => 'Alto',
      '45' => 'Superior',
    ],

    'development'=> [
      '1'  => 'Bajo',
      '30' => 'Básico',
      '38' => 'Alto',
      '45' => 'Superior',
    ],
  ];


  public static function getRango($valor=0): string 
  {
    if ($valor==0) 
    {
      return ''; 
    }

    if ($valor<0)
    {
      return _Icons::solid('face-frown', 'w3-large').'Rango no válido: Inferior a Cero';
    }

    if ($valor>Session::get('rango_nota_superior')) 
    {
      return _Icons::solid('face-frown', 'w3-large').'Rango no válido: Superior a '.Session::get('rango_nota_superior');
    }

    $result = '';
    foreach (self::$aRangos[INSTITUTION_KEY] as $key => $rango)
    {
      $aPartes = explode(separator: '-', string: $key);
      if ( ($valor>=$aPartes[0]) && ($valor<=$aPartes[1]) )
      {
        $result = $rango;
        break;
      }
    }
    return $result;
  }
  
  
  public static function getColorRango($valor=0): string 
  {
    $rango = self::getRango($valor);
    if (array_key_exists($rango, self::$aRangosColores[INSTITUTION_KEY]))
    {
      return self::$aRangosColores[INSTITUTION_KEY][$rango];
    }
    return 'w3-aqua w3-border-theme';
  }
  


}