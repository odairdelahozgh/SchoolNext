<?php
trait EstudianteTraitProps {

  protected static $default_foto_estud = '';
  protected static $default_foto_estud_circle = '';

  public function __toString() { return $this->getNombreCompleto().' '.$this->getCodigo(); }
  public function getCodigo() { return '[Cod: '.$this->id.']'; }
  public function getApellidos() { return $this->apellido1.' '.$this->apellido2; }  
  public function getNombreCompleto($orden='a1 a2, n') {
    return str_replace(
      array('n', 'a1', 'a2'),
      array($this->nombres, $this->apellido1, $this->apellido2),
      $orden
    );
  }

  public function isPazYSalvo() {
    $periodo = Config::get('config.academic.periodo_actual');
    /// cambiar por match expres
    if ($periodo==1 and $this->mes_pagado>=4) { return true; }
    if ($periodo==2 and $this->mes_pagado>=6) { return true; }
    if ($periodo==3 and $this->mes_pagado>=9) { return true; }
    if ($periodo==4 and $this->mes_pagado>=11 and !$this->is_debe_preicfes and !$this->is_debe_almuerzos) { return true; }
    if ($periodo==5 and $this->mes_pagado>=11 and !$this->is_debe_preicfes and !$this->is_debe_almuerzos) { return true; }
    return false;
  }
  public function isPazYSalvoIco() { return ($this->isPazYSalvo()) ? _Icons::solid('face-smile', 'w3-small') : _Icons::solid('face-frown', 'w3-small'); }
  public function getCuentaInstit() { return ($this->email_instit) ? $this->email_instit.'@'.Config::get('config.institution.dominio').' '.$this->clave_instit : ''; }
  
  public function getFoto($max_width=80) { 
    return OdaTags::img(src: "upload/estudiantes/$this->id.png/", alt: $this->id, 
      attrs: "class=\"w3-round\" style=\"width:100%;max-width:".$max_width."px\"", 
      err_message: self::$default_foto_estud);
  }

  public function getFotoCircle($max_width=80) { return OdaTags::img("upload/estudiantes/$this->id.png",$this->id, "class=\"w3-circle w3-bar-item\" style=\"width:100%;max-width:$max_width px\"", self::$default_foto_estud_circle); }

   public function isNuevo() {
    // oj corregir
    return ( (substr($this->created_at, 0,10)>='2022-11-01' ) ? true : false) ;
  }

  public function isNuevoIco() {
    return ( $this->isNuevo() ? '<span class="w3-text-red">NEW</span>' : '' );
  }
 
  public function getPagoPension() {
    return 'Pago Pensión: '.OdaUtils::nombreMes((int)$this->mes_pagado).' de '.$this->annio_pagado;
  }

  public function getDebePreicfes() {
    return 'Debe Preicfes: '.(($this->is_debe_preicfes) ? 'SI' : 'NO');
  }

  public function getDebeAlmuerzos() {
    return 'Debe Almuerzos: '.(($this->is_debe_almuerzos) ? 'SI' : 'NO');
  }

} //END-TraitProps