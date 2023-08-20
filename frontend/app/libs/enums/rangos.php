<?php
enum Rangos: string {
  Use EnumsFunciones;
  
  case Bajo       = 'bajo';
  case Basico     = 'basico';
  case BasicoPlus = 'basico+';
  case Alto       = 'alto';
  case AltoPlus   = 'alto+';
  case Superior   = 'superior';
  
  public function label(): string {
    return match($this) {
      static::Bajo        => 'Bajo',
      static::Basico      => 'Básico',
      static::BasicoPlus  => 'Básico +',
      static::Alto        => 'Alto',
      static::AltoPlus    => 'Alto +',
      static::Superior    => 'Superior',
      default             => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label
  
  public function color(): string {
    return match($this) {
        static::Bajo        => 'red',
        static::Basico      => 'orange',
        static::BasicoPlus  => 'yellow',
        static::Alto        => 'light-blue',
        static::AltoPlus    => 'blue',
        static::Superior    => 'green',
        default             => 'red',
    };
  } //END-color

  public function limiteInf(): string {
    return match($this) {
        static::Bajo        => '1',
        static::Basico      => '60',
        static::BasicoPlus  => '70',
        static::Alto        => '80',
        static::AltoPlus    => '90',
        static::Superior    => '95',
        default             => '0',
    };
  } //END-limiteInf
  
  public function limiteSup(): string {
    return match($this) {
        static::Bajo        => '59',
        static::Basico      => '69',
        static::BasicoPlus  => '79',
        static::Alto        => '89',
        static::AltoPlus    => '94',
        static::Superior    => '100',
        default             => '0',
    };
  } //END-limiteSup

  public function rango(int $valor): string {
    return match($this) {
      $valor > 100  => 'Rango no válido: Superior a 100',
      $valor >= 95  => 'superior',
      $valor >= 90  => 'alto+',
      $valor >= 80  => 'alto',
      $valor >= 70  => 'basico+',
      $valor >= 60  => 'basico',
      $valor >= 1   => 'bajo',
      $valor == 0   => '',
      $valor < 0    => 'Rango no válido: Inferior a Cero',
    };
  } //END-rango

  public static function caption(): string {
    return 'Rango de la califiación';
  }//END-caption

} // END-ENUM