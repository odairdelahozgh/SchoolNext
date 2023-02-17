<?php
trait NotaTraitProps {
  /*
  */
  public function getFoto() { 
    return $this->estudiante_id.'<br>'.OdaTags::img("upload/estudiantes/$this->estudiante_id.png", $this->estudiante_id,
            "class=\"w3-round\" style=\"width:100%;max-width:80px\"", "[sin foto]");
  }
  
  //====================
  public function verNota() {
    $color = (new Rango)::getColorRango($this->nota_final);
    $rango = (new Rango)::getRango($this->nota_final);
    $plan_apoyo = ($this->definitiva<60) ? 'Definitiva: '.$this->definitiva.' => Plan de Apoyo: '.$this->plan_apoyo : '' ;
    return "<span class=\"w3-tag w3-round $color\">
              $this->nota_final $rango
            </span> $plan_apoyo ";
  }

  
} //END-TraitProps