<?php
/**
 * Modelo
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */
class DoliConst extends LiteRecord
{
  private int $rowid;
  private string $name;
  private string $entity;
  private string $value;
  private string $type;
  private string $visible;
  private string $note;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.doli_const');
  }

  public function getValue(string $const_name) 
  {
    $sql = "SELECT * FROM ".static::getSource()." WHERE name=?";
    $Const = (new DoliConst())::first($sql, [$const_name]);
    return $Const->value;
  }

  
}