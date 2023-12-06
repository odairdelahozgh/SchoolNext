<?php

trait NotaTraitLinks {
    public function linkOldPlanApoyoPeriodo() {
        $estud_id = $this->id;
        $salon_id = $this->salon_id;
        $url = Config::get('old.url_schoolweb');
        $periodo_actual = Config::get('config.academic.periodo_actual');
        $btns = '';
        for ($i=1; $i<=$periodo_actual; $i++) { 
            $href="$url/+/coordinacion/GenerarBoletines?salon_id=$salon_id&amp;periodo=$i&amp;estudiante_id=$estud_id&amp;ver_nota=1\"";
            $txt="P$i";
            $attrs="class=\"w3-btn w3-round w3-padding-small w3-red\" target=\"_blank\" title=\"Descargar Boletín : Periodo $i\"";
            $btns .= OdaTags::linkExterno($href, $txt, $attrs).'&bnsp;';
        }
        return '<div class="w3-show-inline-block"><div class="w3-bar">'.$btns.'</div></div>';
    }

  public static function lnkCuadroHonorPrimariaPDF(int $periodo): string {
    try {
      return OdaTags::linkButton(
        action: "admin/notas/exportCuadroHonorPrimariaPdf/$periodo", 
        text: "Top 10 - P$periodo",      
        attrs: 'class="w3-button w3-green" target="_blank"',
      );

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return '';
    }
  } //END-lnkCuadroHonorPrimariaPDF
  
  
  public static function lnkCuadroHonorBachilleratoPDF(int $periodo): string {
    try {
      return OdaTags::linkButton(
        action: "admin/notas/exportCuadroHonorBachilleratoPdf/$periodo", 
        text: "Top 10 - P$periodo",
        attrs: 'class="w3-button w3-green" target="_blank"',
      );

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return '';
    }
  } //END-lnkCuadroHonorBachilleratoPDF
    

  
  public static function lnkCuadroHonorGeneralPrimariaPDF(int $periodo): string {
    try {
      return OdaTags::linkButton(
        action: "admin/notas/exportCuadroHonorGeneralPrimariaPdf/$periodo", 
        text: "Puestos P$periodo",      
        attrs: 'class="w3-button w3-blue" target="_blank"',
      );

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return '';
    }
  } //END-lnkCuadroHonorGeneralPrimariaPDF
  
  
  public static function lnkCuadroHonorGeneralBachilleratoPDF(int $periodo): string {
    try {
      return OdaTags::linkButton(
        action: "admin/notas/exportCuadroHonorGeneralBachilleratoPdf/$periodo", 
        text: "Puestos P$periodo",
        attrs: 'class="w3-button w3-blue" target="_blank"',
      );

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return '';
    }
  } //END-lnkCuadroHonorGeneralBachilleratoPDF


  
  public static function lnkPageCalificar(int $periodo_id, int $salon_id, int $asignatura_id, $enabled=true): string {
    try {
      if (!$enabled) {
        return '';
      }
      return OdaTags::linkButton(
        action: "docentes/notasCalificar/{$periodo_id}/{$salon_id}/{$asignatura_id}", 
        text: "Calificar <br>P{$periodo_id}", 
        icon: '', 
        attrs: 'title="Ingresar NOTAS" class="w3-button w3-small w3-pale-green w3-round-large"',
      );

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return '';
    }
  } //END-lnkPageCalificar


  public static function lnkPageSeguimientos(int $periodo_id, int $salon_id, int $asignatura_id, $enabled=true): string {
    try {
      if (!$enabled) {
        return '';
      }
      return OdaTags::linkButton(
        action: "docentes/notasCalificarSeguimientos/{$periodo_id}/{$salon_id}/{$asignatura_id}", 
        text: "Seguimientos <br>Intermedios P{$periodo_id}", 
        icon: '', 
        attrs: 'title="Ingresar SEGUIMIENTOS INTERMEDIOS" class="w3-button w3-small w3-pale-blue w3-round-large"'
      );

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return '';
    }
  } //END-lnkPageSeguimientos


  public static function lnkPagePlanesApoyo(int $periodo_id, int $salon_id, int $asignatura_id, $enabled=true): string {
    try {
      if (!$enabled) {
        return '';
      }
      return OdaTags::linkButton(
        action: "docentes/notasCalificarPlanesApoyo/{$periodo_id}/{$salon_id}/{$asignatura_id}", 
        text: "Planes de <br>Apoyo P{$periodo_id}", 
        icon: '', 
        attrs: 'title="Ingresar PLANES DE APOYO" class="w3-button w3-small w3-pale-red w3-round-large"'
      );

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return '';
    }
  } //END-lnkPagePlanesApoyo

}//END-Trait