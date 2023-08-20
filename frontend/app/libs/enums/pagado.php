<?php

enum Pagado: int {
  Use EnumsFunciones;

  case No = 0;
  case Si = 1;

  //public const Bueno = self::Si;

  public function label(): string {
    return match($this) {
      static::No  => 'No Pagado',
      static::Si  => 'Pagado',
      default     => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  } //END-label
  
  public function ico(): string {
    $ico = match($this) {
        static::No => 'fa-sack-ban',
        static::Si => 'fa-sack-dollar',
        default    => 'fa-question',
    };
    return "<i class=\"fa-solid $ico w3-small\"></i>&nbsp;";
  } //END-ico
  
  public function label_ico(): string {
    return $this->ico().$this->label();
  } //END-label_ico

  public function color(): string {
    return match($this) {
        static::No => 'red',
        static::Si => 'green',
        default    => 'red',
    };
  }//END-color

  public static function caption(): string {
    return 'Estado del pago';
  }//END-caption

} //END-ENUM