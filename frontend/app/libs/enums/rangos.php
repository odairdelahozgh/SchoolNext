<?php
enum Rangos: string {
  Use EnumsFunciones;
  
  case Bajo       = 'bajo';
  case Basico     = 'basico';
  case Alto       = 'alto';
  case Superior   = 'superior';
  
  public function label(): string
  {
    return match($this)
    {
      static::Bajo        => 'Bajo',
      static::Basico      => 'Básico',
      static::Alto        => 'Alto',
      static::Superior    => 'Superior',
      default             => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }

  public function color(): string 
  {
    return match($this) 
    {
      static::Bajo        => 'crimson',
      static::Basico      => 'coral',
      static::Alto        => 'light-blue',
      static::Superior    => 'seagreen',
      default             => 'crimson',
    };
  }

  public function limiteInf(): string 
  {
    return match($this) 
    {
      static::Bajo        => '1',
      static::Basico      => '60',
      static::Alto        => '80',
      static::Superior    => '95',
      default             => '0',
    };
  }
  
  public function limiteSup(): string 
  {
    return match($this) 
    {
      static::Bajo        => '59',
      static::Basico      => '79',
      static::Alto        => '94',
      static::Superior    => '100',
      default             => '0',
    };
  }

  public function rango(int $valor): string 
  {
    return match($this) 
    {
      $valor > 100  => 'Rango no válido: Superior a 100',
      $valor >= 95  => 'superior',
      $valor >= 80  => 'alto',
      $valor >= 60  => 'basico',
      $valor >= 1   => 'bajo',
      $valor == 0   => '',
      $valor < 0    => 'Rango no válido: Inferior a Cero',
    };
  }

  public static function caption(): string 
  {
    return 'Rango de la califiación';
  }

}