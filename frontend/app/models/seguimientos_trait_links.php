<?php

trait SeguimientosTraitLinks {

  public static function lnkPageSeguimientosGrupo(): string {
    try {
      return OdaTags::linkButton(
        action: "docentes/seguimientos_grupo", 
        text: "Ver Seguimientos del Grupo",      
        attrs: 'class="w3-button w3-pale-blue"',
      );

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return '';
    }
  } //END-lnkCuadroHonorPrimariaPDF
  

}//END-Trait