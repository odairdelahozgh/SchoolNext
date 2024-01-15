<?php
/**
 * Modelo Area
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

class Area extends LiteRecord
{
  use AreaTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.areas');
    $this->setUp();
  }

  public static function getLista(string $fields = '*') 
  {
    //$sql = QueryGenerator::select(static::getSource(), 'mysql', []);
    $sql = "SELECT $fields FROM ".static::getSource();
    return static::query($sql);
  }

} //END-CLASS