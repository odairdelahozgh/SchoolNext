<?php
/**
  * Modelo de Usuario  
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
  */

class Usuario extends LiteRecord
{
  use UsuarioDefa;
  
  protected static $table = 'dm_user';
  
  public function __construct() {
    self::$_defaults     = $this->getTDefaults();
    self::$_labels       = $this->getTLabels();
    self::$_placeholders = $this->getTPlaceholders();
    self::$_helps        = $this->getTHelps();
    self::$_attribs      = $this->getTAttribs();
  }
  
   //=========
   public function __toString() {
    return $this->getNombreCompleto('a1 a2 n');
    }

    
    //=========
    public function getNombreCompleto2($orden='a1 a2, n', $sanear=true, $humanize=false) {
        if ($sanear) {
            $this->nombres   = OdaUtils::sanearString($this->nombres);
            $this->apellido1 = OdaUtils::sanearString($this->apellido1);
            $this->apellido2 = OdaUtils::sanearString($this->apellido2);
        }
        if ($humanize) {
            $this->nombres   = OdaUtils::nombrePersona($this->nombres);
            $this->apellido1 = OdaUtils::nombrePersona($this->apellido1);
            $this->apellido2 = OdaUtils::nombrePersona($this->apellido2);
        }
        
        return str_replace(
            array('n', 'a1', 'a2'),
            array($this->nombres, $this->apellido1, $this->apellido2),
            $orden);
    }

    //=========
    public function getNombreCompleto($orden='a1 a2, n') {
        return str_replace(
            array('n', 'a1', 'a2'),
            array($this->nombres, $this->apellido1, $this->apellido2),
            $orden);
    }

    //=========
    public function getIsActiveF() {
        return (($this->is_active) ? '<i class="bi-check-circle-fill">' : '<i class="bi-x">');
    }
}