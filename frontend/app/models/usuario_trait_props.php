<?php
trait UsuarioTraitProps {

  public function __toString() {
    return $this->getNombreCompleto('a1 a2 n');
  }

  /*
   * Devuelve una composición del nombre completo del usuario
   */
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
        
    return str_replace( array('n', 'a1', 'a2'),
            array($this->nombres, $this->apellido1, $this->apellido2), $orden);
    }

  /*
   * Devuelve una composición del nombre completo del usuario
   */
  public function getNombreCompleto($orden='a1 a2, n') {
    return str_replace( array('n', 'a1', 'a2'),
            array($this->nombres, $this->apellido1, $this->apellido2), $orden);
  }

  
} //END-TraitProps