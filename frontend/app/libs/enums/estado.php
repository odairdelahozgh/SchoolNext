<?php

enum Estado: int {
  Use EnumsFunciones;

  case Inactivo = 0;
  case Activo   = 1;

  public const Bueno = self::Activo;

  public function label(): string {
    return match($this) {
      static::Inactivo => 'Inactivo',
      static::Activo   => 'Activo',
      default          => 'Inactivo',
    };
  }//END-label
  
  public function ico(): string {
    $ico = match($this) {
        static::Inactivo => 'fa-face-frown',
        static::Activo   => 'fa-face-smile',
        default          => 'fa-face-frown',
    };
    return "<i class=\"fa-solid $ico w3-small\"></i>&nbsp;";
  }//END-ico
  
  public function label_ico(): string {
    return $this->ico().$this->label();
  }

  public function color(): string {
    return match($this) {
        static::Inactivo => 'red',
        static::Activo   => 'green',
        default          => 'red',
    };
  }//END-color

} //END-ENUM-Estado