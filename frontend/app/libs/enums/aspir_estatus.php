<?php

enum AspirEstatus: string {
  Use EnumsFunciones;

  case Estudio   = 'Estudio';
  case Admitido  = 'Admitido';
  case Rechazado = 'Rechazado';

  public function label(): string {
    return match($this) {
      static::Estudio   => 'En Estudio',
      static::Admitido  => 'Admitido',
      static::Rechazado => 'Rechazado',
      default           => 'En Estudio',
    };
  }//END-label

  public static function caption(): string {
    return 'Estado de la Solicitud';
  }//END-caption

} //END-ENUM