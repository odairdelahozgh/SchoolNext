<?php

enum Sexo: string {
  Use EnumsFunciones;

  case Masculino = 'Masculino';
  case Femenino  = 'Femenino';

  public function label(): string {
    return match($this) {
      static::Masculino => 'Masculino',
      static::Femenino  => 'Femenino',
      default           => 'No definido',
    };
  }//END-label
  
  public function ico(): string {
    $ico = match($this) {
        static::Masculino => 'fa-??',
        static::Femenino  => 'fa-??',
        default           => 'fa-??',
    };
    return "<i class=\"fa-solid $ico w3-small\"></i>&nbsp;";
  }//END-ico
  
  public function label_ico(): string {
    return $this->ico().$this->label();
  }//END-label_ico

  public function color(): string {
    return match($this) {
        static::Masculino => 'blue',
        static::Femenino  => 'green',
        default           => 'pink',
    };
  }//END-color

  public static function caption(): string {
    return 'Sexo';
  }//END-caption
  
} //END-ENUM