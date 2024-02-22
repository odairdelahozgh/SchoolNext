<?php
trait EstudianteTraitLinks {

  public function getLnkEditPage(string $caption, string $attrs=''): string 
  {
    return OdaTags::link(
      action: "secretaria/editEstudiante/$this->id", 
      text: $caption, 
      attrs: $attrs);
  }


  public function getLnkBoletin(int $periodo): string 
  {
    return OdaTags::linkButton (
      action: "admin/notas/exportBoletinEstudiantePdf/$periodo/$this->uuid", 
      text: "<i class=\"fa-solid fa-file-pdf\"></i> P$periodo", 
      attrs: "title=\"Descargar Boletín P$periodo $this\" target=\"_blank\" class=\"w3-btn w3-ripple w3-round-large w3-small\"");
  }
  

  public function getLnkBoletinesTodos(): string 
  {
    $max_periodo = (4==self::$_periodo_actual) ? 5 : self::$_periodo_actual;
    $lnk = '';
    for ($i=1; $i<=$max_periodo; $i++) { 
      $lnk .= $this->getLnkBoletin($i).'&nbsp;';
    }
    return $lnk;
  }


  public function getLnkPlanApoyo(int $periodo) 
  {
    try {
      /// pensarlo mejor.. no está listo
      return OdaTags::linkButton (
        action: "admin/planes_apoyo/exportPlanesApoyoRegistroPdf/$this->uuid",
        text: "<i class=\"fa-solid fa-file-pdf\"></i> P.A. P$periodo",
        attrs: " target=\"_blank\" class=\"w3-btn w3-ripple w3-round-large w3-small\"");

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }

  
  public function getLnkPlanesApoyoTodos() 
  {
    try {
      $lnk = '';
      for ($i=1; $i<=self::$_periodo_actual; $i++) { 
        $lnk .= $this->getLnkPlanApoyo($i).'&nbsp;';
      }
      return $lnk;

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }


  public function getlnkSetMesPagosTodos(): string 
  {
    $lnk='Establecer Mes de Pago a:<br>';
    for ($i=2; $i<=11; $i++) { 
      $nombre_mes = OdaUtils::nombreMes($i, true);
      $lnk .= '<span class="w3-tag w3-blue w3-round">' .Html::linkAction("setMesPago/$this->id/$i", "$nombre_mes"). '</span>&nbsp &nbsp';
    }

    return $lnk.'<br>';
  }
  

  public function getlnkSetPonerAldia(): string 
  {
    $lnk ='';
    if(!$this->isPazYSalvo()) {
      $lnk .= '<span class="w3-tag w3-green w3-round">' 
        .Html::linkAction(
            action: "actualizarPago/$this->id/", 
            text: 'Poner al Dia',
            attrs: 'title="Establece pago a mes de '.$this->nombre_mes_enum(self::LIM_PAGO_PERIODOS[self::$_periodo_actual]).'"' 
        )
      .'</span>';
      return $lnk;
    }
    return $lnk;
  }


  public static function getLnkListaGenerica(string $salon_id) 
  {
    try {
      $RegSalon = (new Salon)::get($salon_id);
      return OdaTags::linkButton (
        action: "admin/estudiantes/exportEstudiantesBySalonPdf/$RegSalon->uuid", 
        text: "<i class=\"fa-solid fa-file-pdf\"></i> $RegSalon->nombre", 
        attrs: " target=\"_blank\" class=\"w3-btn w3-ripple w3-round-large w3-small\"");

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }


  public function getLnkRetirar(RetiroEstudiante $motivo) 
  {
    try {
      return Html::linkAction("retirarEstudiante/{$this->id}/$motivo->name", "{$motivo->label()}", "class=\"w3-button w3-pale-{$motivo->color()} w3-block\"");

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }

  
  public function getLnkVincularPadresHijos()
  {
    return Html::linkAction(
      "vincularPadresHijos/{$this->id}", 
      "Padres Hijos", 
      "class=\"w3-button w3-pale-blue w3-block\""
    );
  }

}