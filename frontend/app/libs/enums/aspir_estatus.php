<?php

enum AspirEstatus: string {
  Use EnumsFunciones;

  case Estudio   = 'Estudio';
  case Admitido  = 'Admitido';
  case Rechazado = 'Rechazado';

  public function label(bool $abrev = false): string {
    return match($this) {
      static::Estudio   => 'En Estudio',
      static::Admitido  => 'Admitido',
      static::Rechazado => 'Rechazado',
      default           => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label

  public static function caption(): string {
    return 'Estado de la Solicitud';
  }//END-caption

} //END-ENUM