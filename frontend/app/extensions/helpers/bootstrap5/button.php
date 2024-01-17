<?php
/**
 * // Ejemplo de uso
 * $boton = new BootstrapButton("Haz clic", "primary", "lg");
 * echo $boton->generarButton();
 */
class BootstrapButton {

  public function __construct
  (
    private $texto, private $tipo, private $tamanio) {
  }
  public function generarButton() 
  {
    return '<button type="button" class="btn btn-' .$this->tipo .' btn-' .$this->tamanio .'">' .$this->texto .'</button>';
  }


}