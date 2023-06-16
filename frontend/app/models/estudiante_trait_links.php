<?php
trait EstudianteTraitLinks {

  public function linkOld_BoletinPeriodo() {
    $estud_id = $this->id;
    $salon_id = $this->salon_id;
    $url = Config::get('old.url_schoolweb');
    $periodo_actual = Config::get('config.academic.periodo_actual');
    $btns = '';
    for ($i=1; $i<=$periodo_actual; $i++) { 
        $href="$url/+/coordinacion/GenerarBoletines?salon_id=$salon_id&amp;periodo=$i&amp;estudiante_id=$estud_id&amp;ver_nota=1\"";
        $txt="P$i";
        $attrs="class=\"w3-btn w3-round w3-padding-small w3-red\" target=\"_blank\" title=\"Descargar Boletín : Periodo $i\"";
        $btns .= OdaTags::linkExterno($href, $txt, $attrs).'&ensp;';
    }
    return '<div class="w3-show-inline-block"><div class="w3-bar">'.$btns.'</div></div>';
  }


  public function link_SetMesPagosTodos(): string {
    $lnk='Establecer Mes de Pago a:<br>';
    for ($i=2; $i<=11; $i++) { 
      $nombre_mes = "[$i] ".OdaUtils::nombreMes(mes: $i, abrev: true);
      $lnk .= '<span class="w3-tag w3-blue w3-round">' .Html::linkAction(action: "setMesPago/$this->id/$i", text: "$nombre_mes"). '</span>&nbsp &nbsp';
    }
    return $lnk;
  } //END-link_SetMesPagosTodos




} //END-TraitLinksOlds