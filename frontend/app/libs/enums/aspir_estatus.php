<?php

enum AspirEstatus: string {
  Use EnumsFunciones;

  case Estudio   = 'En Estudio';
  case Admitido  = 'Admitido';
  case Rechazado = 'Rechazado';

  public function label(bool $abrev = false): string {
    return match($this) {
      static::Estudio   => (($abrev)?'ES':'En Estudio'),
      static::Admitido  => (($abrev)?'AD':'Admitido'),
      static::Rechazado => (($abrev)?'RE':'Rechazado'),
      default           => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label

  public function ico(bool $with_color=true, $attr_class=''): string {
    $ico = match($this) {
        static::Estudio   => 'fa-user-clock',
        static::Admitido  => 'fa-user-check',
        static::Rechazado => 'fa-user-minus',
        default           => 'fa-question',
    };
    $color = ($with_color) ? 'style="color: '.self::color().'"' : '' ;
    return "<i class=\"fa-solid $ico $attr_class\" $color></i>&nbsp;";
  } //END-ico
  
  public function color(): string {
    return match($this) {
        static::Estudio => 'dodgerblue',
        static::Admitido => 'seagreen',
        static::Rechazado => 'crimson',
        default    => 'crimson',
    };
  }//END-color


  public function label_ico(bool $with_color=true, $attr_class=''): string {
    return $this->ico($with_color, $attr_class).$this->label($attr_class);
  } //END-label_ico


  public static function caption(): string {
    return 'Estado de la Solicitud';
  }//END-caption

} //END-ENUM