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


  public function getLnkPlanApoyo(int $periodo): string {
    try {
      return OdaTags::linkButton (
        //admin/planes_apoyo/exportPlanesApoyoEstudiantePdf/'+reg_uuid+'"
        action: "admin/planes_apoyo/exportPlanesApoyoEstudiantePdf/$this->uuid", 
        text: "Bolet&iacute;n P$periodo", 
        attrs: " target=\"_blank\" class=\"w3-button w3-pale-red\"");

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getLnkBoletin
  
  public function getLnkPlanesApoyoTodos(): string {
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