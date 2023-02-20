<?php
/**
 * Modelo RegistrosDesemp * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */
  
 trait RegistroDesempAcadTraitProps {

  public function getFecha($date_format="d-M-Y") { return date($date_format, strtotime($this->fecha)); } // END-getFecha
  
  // ===========
  public function getFotoAcudiente() {
    if (!$this->foto_acudiente) { return 'no foto_acudiente'; }
    $filename = 'estud_reg_des_aca_com/'.$this->foto_acudiente;
    return OdaTags::fileimg($filename, "class=\"w3-round\" style=\"width:100%;max-width:80px\"");
  } // END-getFotoAcudiente
  
  // ===========
  public function getFotoDirector() {
    if (!$this->foto_director) { return 'no foto_director'; }
    $filename = 'estud_reg_des_aca_com/'.$this->foto_director;
    return OdaTags::fileimg($filename, "class=\"w3-round\" style=\"width:100%;max-width:80px\"");
  } // END-getFotoDirector


} //END-CLASS