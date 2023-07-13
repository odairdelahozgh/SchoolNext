<?php

trait RegistrosGenTraitProps {

  public function __toString() { return $this->fecha.'<br>'.$this->annio .'-P' .$this->periodo_id ; }

  public function getFecha($date_format="d-M-Y") { return date($date_format, strtotime($this->fecha)); }
  
  public function getFotoAcudiente() {
    try {
      if (!$this->foto_acudiente) {  return 'sin evidencia'; }
      $filename = 'estud_reg_observ_gen/'.$this->foto_acudiente;
      return OdaTags::fileimg($filename, "class=\"w3-round\" style=\"width:100%;max-width:80px\"");
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } // END-getFotoAcudiente
  
  public function getFotoDirector() {
    try {
      if (!$this->foto_director) { return 'sin evidencia'; }
      $filename = 'estud_reg_observ_gen/'.$this->foto_director;
      return OdaTags::fileimg($filename, "class=\"w3-round\" style=\"width:100%;max-width:80px\"");
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } // END-getFotoDirector

  public function isRegistroOk() {
    try {
      if ( (0==strlen($this->foto_director)) or (0==strlen($this->foto_acudiente)) ) { 
        return false;
      }
      return true;
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-isRegistroOk
  
  

} //END-Trait