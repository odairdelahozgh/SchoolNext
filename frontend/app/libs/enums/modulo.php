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
  
  
  public function label(): string {
    return match($this) {
      static::Admin  => 'Administrador',
      static::Conta  => 'Contabilidad',
      static::Coord  => 'Coordinacion',
      static::Docen  => 'Docentes',
      static::Enfer  => 'Enfermeria',
      static::Padre  => 'Padres',
      static::Psico  => 'Psicologia',
      static::Secre  => 'Secretaria',
      default => throw new InvalidArgumentException(message: "Modulo Erroneo"),
    };
  } //END-label

  public function ico(): string {
    return "<i class=\"fa-solid fa-calendar-days w3-small\"></i>&nbsp;";
  } //END-ico
  
  public function label_ico(): string {
    return $this->ico().$this->label();
  } //END-label_ico


} // END-ENUM