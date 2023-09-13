<?php

trait RegistrosGenTraitLinks {

  public function lnkEditRegistro($nombre_estudiante): string {
    $result = '';
    if (!$this->isRegistroOk()) { 
      $result = "
      <button 
        id=\"id_btn_edit\" 
        class=\"w3-btn w3-pale-green\" 
        onclick=\"show_edit_form($this->id, '$nombre_estudiante')\">
          Editar
      </button>";
    }
    return $result;
  } // END-lnkEditRegistro


} //END-Trait