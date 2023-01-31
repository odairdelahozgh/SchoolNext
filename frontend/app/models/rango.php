<?php
/**
  * Modelo de Rango  
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
  */

/*
 nombre, lim_inf, lim_sup, color_rango, color_texto, color_backg, 
 id, created_by, updated_by, created_at, updated_at
*/
class Rango extends LiteRecord
{
  protected static $table = 'sweb_ejemplo';
  protected static $aRangos = array(
    '1-59'   => 'Bajo',
    '60-69'  => 'Básico',
    '61-79'  => 'Básico +',
    '80-89'  => 'Alto',
    '90-94'  => 'Alto +',
    '95-100' => 'Superior',
  );
  protected static $aRangosColores = array(
    'Bajo'     => 'w3-red',
    'Básico'   => 'w3-orange',
    'Básico +' => 'w3-yellow',
    'Alto'     => 'w3-light-blue',
    'Alto +'   => 'w3-blue',
    'Superior' => 'w3-green',
  );

  public function __construct() {
    //self::$aRangos = array();
  }
  
  const IS_ACTIVE = [
        0 => 'Inactivo',
        1 => 'Activo'
  ];
  
  public function __toString() { return $this->nombre; }
  
  //====================
  public static function getRango($valor=0) {
    if ($valor==0)  { return ''; }
    if ($valor<0)   { return _Icons::solid('face-frown','w3-large').'Rango no válido: Inferior a Cero'; }
    if ($valor>100) { return _Icons::solid('face-frown','w3-large').'Rango no válido: Superior a 100'; }
    foreach (self::$aRangos as $key => $rango) {
      $aPartes = explode('-', $key);
      if ( ($valor>=$aPartes[0]) && ($valor<=$aPartes[1]) ) {
        return $rango;
      }
    }
  } //END-getRango
  
  //====================
  public static function getColorRango($valor=0)  {
    $rango = self::getRango($valor);
    if (array_key_exists($rango, self::$aRangosColores)) {
      return self::$aRangosColores[$rango];
    } else {
      return 'w3-aqua w3-border-theme';
    }
  } //END-getColorRango

  // public function create(array $data = []): bool
  // public function update(array $data = []): bool
  // public function save(array $data = []): bool
  // public static function delete($pk): bool
  // 
  // public static function get($pk, $fields = '*')
  // public static function all(string $sql = '', array $values = []): array
  // public static function first(string $sql, array $values = []): static
  // public static function filter(string $sql, array $values = []): array

}