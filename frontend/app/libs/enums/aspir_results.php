<?php

enum AspirResults: string {
  Use EnumsFunciones;

  case Nulo   = '';
  case Alto   = 'Alto';
  case Basico = 'Básico';
  case Bajo   = 'Bajo';

  public function label(bool $abrev = false): string {
    return match($this) {
      static::Nulo   => '',
      static::Alto   => (($abrev)?'AL':'Alto'),
      static::Basico => (($abrev)?'BA':'Básico'),
      static::Bajo   => (($abrev)?'BJ':'Bajo'),
      default        => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label

  public static function caption(): string {
    return 'Resultado Examen';
  }//END-caption

} //END-ENUM