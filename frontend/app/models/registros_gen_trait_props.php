<?php

trait RegistrosGenTraitProps {

  public function __toString() { return $this->fecha.'<BR>'.$this->annio .'-P' .$this->periodo_id ; }
  public function getFecha($date_format="d-M-Y") { return date($date_format, strtotime($this->fecha)); }
  
  // ===========
  public function getFotoAcudiente() {
    if (!$this->foto_acudiente) { return 'sin evidencia'; }
    $filename = 'estud_reg_observ_gen/'.$this->foto_acudiente;
    return OdaTags::fileimg($filename, "class=\"w3-round\" style=\"width:100%;max-width:80px\"");
  } // END-getFotoAcudiente
  
  // ===========
  public function getFotoDirector() {
    if (!$this->foto_director) { return 'sin evidencia'; }
    $filename = 'estud_reg_observ_gen/'.$this->foto_director;
    return OdaTags::fileimg($filename, "class=\"w3-round\" style=\"width:100%;max-width:80px\"");
  } // END-getFotoDirector



} //END-Class