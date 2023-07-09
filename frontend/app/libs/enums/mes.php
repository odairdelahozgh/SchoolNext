<?php
enum Mes: int {
  Use EnumsFunciones;

  case Enero = 1;
  case Febrero = 2;
  case Marzo = 3;
  case Abril = 4;
  case Mayo = 5;
  case Junio = 6;
  case Julio = 7;
  case Agosto = 8;
  case Septiembre = 9;
  case Octubre = 10;
  case Noviembre = 11;
  case Diciembre = 12;
  
  public function label(): string {
    return match($this) {
      static::Enero      => 'Enero',
      static::Febrero    => 'Febrero',
      static::Marzo      => 'Marzo',
      static::Abril      => 'Abril',
      static::Mayo       => 'Mayo',
      static::Junio      => 'Junio',
      static::Julio      => 'Julio',
      static::Agosto     => 'Agosto',
      static::Septiembre => 'Septiembre',
      static::Octubre    => 'Octubre',
      static::Noviembre  => 'Noviembre',
      static::Diciembre  => 'Diciembre',
      default            => throw new InvalidArgumentException(message: "Mes Erroneo"),
    };
  }//END-label

  public function ico(): string {
    return "<i class=\"fa-solid fa-calendar-days w3-small\"></i>&nbsp;";
  }//END-ico
  
  public function label_ico(): string {
    return $this->ico().$this->label();
  }


} // END-ENUM