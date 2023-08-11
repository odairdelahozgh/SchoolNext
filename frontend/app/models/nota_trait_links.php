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
        text: "Honor Primaria P$periodo",      
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
        text: "Honor Bachillerato P$periodo",
        attrs: 'class="w3-button w3-green" target="_blank"',
      );

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return '';
    }
  } //END-lnkCuadroHonorBachilleratoPDF
    
}