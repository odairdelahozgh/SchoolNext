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

  
  public static function lnkPageRegistrosGrupo(): string {
    try {
      return OdaTags::linkButton(
        action: "docentes/registros_grupo", 
        text: "Ver Registros del Grupo",      
        attrs: 'class="w3-button w3-pale-blue"',
      );

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return '';
    }
  } //END-lnkCuadroHonorPrimariaPDF
  

} //END-Trait