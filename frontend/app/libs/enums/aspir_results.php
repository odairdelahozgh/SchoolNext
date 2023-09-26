<?php

enum AspirResults: string {
  Use EnumsFunciones;

  case Alto   = 'Alto';
  case Basico = 'Básico';
  case Bajo   = 'Bajo';

  public function label(bool $abrev = false): string {
    return match($this) {
      static::Alto   => 'Alto',
      static::Basico => 'Básico',
      static::Bajo   => 'Bajo',
      default        => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label

  public static function caption(): string {
    return 'Resultado Examen';
  }//END-caption

} //END-ENUM