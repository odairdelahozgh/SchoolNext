<?php
trait EstudianteTraitLinks {

  public function getLnkBoletin(int $periodo): string {
    try {
      return OdaTags::linkButton (
        action: "admin/notas/exportBoletinEstudiantePdf/$periodo/$this->uuid", 
        text: "<i class=\"fa-solid fa-file-pdf\"></i> Bolet&iacute;n P$periodo", 
        attrs: " target=\"_blank\" class=\"w3-btn w3-ripple w3-round-large w3-small\"");

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getLnkBoletin
  
  public function getLnkBoletinesTodos(): string {
    try {
      $lnk = '';
      for ($i=1; $i<=self::$_periodo_actual; $i++) { 
        $lnk .= $this->getLnkBoletin($i).'&nbsp;';
      }
      return $lnk;

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getLnkBoletinesTodos


  public function getLnkPlanApoyo(int $periodo): string {
    try {
      /// pensarlo mejor.. no está listo
      return OdaTags::linkButton (
        action: "admin/planes_apoyo/exportPlanesApoyoRegistroPdf/$this->uuid",
        text: "<i class=\"fa-solid fa-file-pdf\"></i> P.A. P$periodo",
        attrs: " target=\"_blank\" class=\"w3-btn w3-ripple w3-round-large w3-small\"");

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getLnkBoletin
  
  public function getLnkPlanesApoyoTodos(): string {
    try {
      $lnk = '';
      for ($i=1; $i<=self::$_periodo_actual; $i++) { 
        $lnk .= $this->getLnkPlanApoyo($i).'&nbsp;';
      }
      return $lnk;

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getLnkBoletinesTodos


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