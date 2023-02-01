<?php
trait NotaTraitProps {
  /*
  public function __toString() { return $this->id.' '.$this->nombre; }
  */
  public function getFoto() { 
    return $this->estudiante_id.'<br>'.OdaTags::img("upload/estudiantes/$this->estudiante_id.png", $this->estudiante_id,
            "class=\"w3-round\" style=\"width:100%;max-width:80px\"", "[sin foto]");
  }
  

} //END-TraitProps