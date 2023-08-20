<?php
enum Modulo: int {

  Use EnumsFunciones;
  
  case Admin = 1;
  case Conta = 2;
  case Coord = 3;
  case Docen = 4;
  case Enfer = 5;
  case Padre = 6;
  case Psico = 7;
  case Secre = 8;
  
  
  public function label(bool $abrev=false): string {
    return match($this) {
      static::Admin  => (($abrev)?'Admin':'Administrador'),
      static::Conta  => (($abrev)?'Cont':'Contabilidad'),
      static::Coord  => (($abrev)?'Coor':'Coordinacion'),
      static::Docen  => (($abrev)?'Doce':'Docentes'),
      static::Enfer  => (($abrev)?'Enfe':'Enfermeria'),
      static::Padre  => (($abrev)?'Padr':'Padres'),
      static::Psico  => (($abrev)?'Psic':'Psicologia'),
      static::Secre  => (($abrev)?'Secr':'Secretaria'),
      default => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  } //END-label

  public function ico(): string {
    return "<i class=\"fa-solid fa-layer-group w3-small\"></i>&nbsp;";
  } //END-ico
  
  public function label_ico(): string {
    return $this->ico().$this->label();
  } //END-label_ico

  public static function caption(): string {
    return 'M&oacute;dulo del sistema';
  }//END-caption


} // END-ENUM