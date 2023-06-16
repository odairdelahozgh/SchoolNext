<?php
trait EstudianteTraitProps {

  protected static $default_foto_estud = '';
  protected static $default_foto_estud_circle = '';

  public function __toString() { return $this->getNombreCompleto(sanear:true, mayuscula:false).' '.$this->getCodigo(); }
  public function getCodigo() { return '[Cod: '.$this->id.']'; }
  public function getApellidos() { return $this->apellido1.' '.$this->apellido2; }
  public function getNombreCompleto($orden='a1 a2, n', $sanear=true, $mayuscula=false) {
    $nombre_completo = str_replace(
      array('n', 'a1', 'a2'),
      array( $this->nombres, $this->apellido1, $this->apellido2),
      $orden
    );
    if ($sanear) { $nombre_completo = OdaUtils::sanearString($nombre_completo);  }
    $nombre_completo = mb_convert_case($nombre_completo, MB_CASE_TITLE, "UTF-8");
    if ($mayuscula) { $nombre_completo = strtoupper($nombre_completo); }
    return $nombre_completo;
  } //getNombreCompleto
  public function isPazYSalvo(): bool {
    $periodo = (int)Config::get(var: 'config.academic.periodo_actual');
    $annio = (int)Config::get(var: 'config.academic.annio_actual');

    // cambiar por match expres
    if ($periodo==1 and $this->mes_pagado>=4 and $this->annio_pagado==$annio)  { return true; }
    if ($periodo==2 and $this->mes_pagado>=6 and $this->annio_pagado==$annio) { return true; }
    if ($periodo==3 and $this->mes_pagado>=9 and $this->annio_pagado==$annio) { return true; }
    if ($periodo==4 and $this->mes_pagado>=11 and $this->annio_pagado==$annio and !$this->is_debe_preicfes and !$this->is_debe_almuerzos) { return true; }
    if ($periodo==5 and $this->mes_pagado>=11 and $this->annio_pagado==$annio and !$this->is_debe_preicfes and !$this->is_debe_almuerzos) { return true; }
    return false;
  }
  public function isPazYSalvoIco() { return ($this->isPazYSalvo()) ? _Icons::solid('face-smile', 'w3-small') : _Icons::solid('face-frown', 'w3-small'); }
  public function getCuentaInstit($show_ico=false) { 
    $ico = ($show_ico) ? OdaTags::img(src:'msteams_logo.svg', attrs:'width="16"', err_message:'').' ' : 'MS Teams: ' ;
    return $ico.(($this->email_instit) ? $this->email_instit.'@'.Config::get('config.institution.dominio').' '.$this->clave_instit : 'No tiene usuario en MS TEAMS'); 
  }
  
  public function getFoto($max_width=80) { 
    //return OdaTags::img(src: "upload/estudiantes/$this->id.png/", alt: $this->id, 
    return OdaTags::img(src: IMG_ESTUDIANTES_PATH."$this->id.png", alt: $this->id, 
      attrs: "class=\"w3-round\" style=\"width:100%;max-width:".$max_width."px\"", 
      err_message: self::$default_foto_estud);
  }

  public function getFotoCircle($max_width=80) { return OdaTags::img("upload/estudiantes/$this->id.png",$this->id, "class=\"w3-circle w3-bar-item\" style=\"width:100%;max-width:$max_width px\"", self::$default_foto_estud_circle); }
  public function isNuevo() { 
    $fecha_lim = (string)(Date('Y')-1).'-10-01';
    return ( (substr($this->created_at, 0,10)>=$fecha_lim ) ? true : false);
  }
  public function isNuevoIco() { return ( $this->isNuevo() ? '<span class="w3-text-red">NEW</span>' : '' ); }
  public function getPagoPension() { return 'Pago Pensión: '.OdaUtils::nombreMes((int)$this->mes_pagado).' de '.$this->annio_pagado; }
  public function getDebePreicfes() { return 'Debe Preicfes: '.(($this->is_debe_preicfes) ? 'SI' : 'NO'); }
  public function getDebeAlmuerzos() { return 'Debe Almuerzos: '.(($this->is_debe_almuerzos) ? 'SI' : 'NO'); }

} //END-TraitProps