<?php
trait EstudianteTraitLinks {

  public function getLnkBoletin(int $periodo): string {
    try {
      return OdaTags::linkButton (
        action: "admin/notas/exportBoletinEstudiantePdf/$periodo/$this->uuid", 
        text: "Bolet&iacute;n P$periodo", 
        attrs: " target=\"_blank\" class=\"w3-button w3-pale-red\"");

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getLnkBoletin
  
  public function getLnkBoletinesTodos(): string {
    try {
      $lnk = '';
      for ($i=1; $i<=self::$_periodo_actual; $i++) { 
        $lnk .= $this->getLnkBoletin($i).'&nbsp;&nbsp;';
      }
      return $lnk;

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getLnkBoletinesTodos

  // public function linkOldPlanApoyoId() {
  //   $estud_id = $this->id;
  //   $salon_id = $this->salon_id;
  //   $url = Config::get('old.url_schoolweb');
  //   $periodo_actual = Config::get('config.academic.periodo_actual');
  //   $btns = '';
  //   for ($i=1; $i<=$periodo_actual; $i++) { 
  //       $href="$url/+/notas/PlanesApoyoFinalPadresPDF?id=1"";
  //       $txt="P$i";
  //       $attrs="class=\"w3-btn w3-round w3-padding-small w3-red\" target=\"_blank\" title=\"Descargar Boletín : Periodo $i\"";
  //       $btns .= OdaTags::linkExterno($href, $txt, $attrs).'&ensp;';
  //   }
  //   return '<div class="w3-show-inline-block"><div class="w3-bar">'.$btns.'</div></div>';
  // }


  public function getlnkSetMesPagosTodos(): string {
    $lnk='Establecer Mes de Pago a:<br>';
    for ($i=2; $i<=11; $i++) { 
      $nombre_mes = "[$i] ".OdaUtils::nombreMes(mes: $i, abrev: true);
      $lnk .= '<span class="w3-tag w3-blue w3-round">' .Html::linkAction(action: "setMesPago/$this->id/$i", text: "$nombre_mes"). '</span>&nbsp &nbsp';
    }
    return $lnk.'<br>';
  } //END-getlnkSetMesPagosTodos

  

  public function getlnkSetPonerAldia(): string {
    $lnk ='';
    if(!$this->isPazYSalvo()) {
      $lnk .= '<span class="w3-tag w3-green w3-round">' 
        .Html::linkAction(
            action: "actualizarPago/$this->id/", 
            text: 'Poner al Dia ('.$this->nombre_mes_enum(self::LIM_PAGO_PERIODOS[self::$_periodo_actual]).') '._Icons::solid('coins', 'w3-large'))
      .'</span>';
      return $lnk.'<br>';
    }
    return $lnk;
  } //END-getlnkSetPonerAldia





} //END-TraitLinksOlds