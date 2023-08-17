<?php

enum TipoDoc: string {
  Use EnumsFunciones;

  case Registro = 'RC';
  case Tarjeta  = 'TI';
  case Cedula  = 'CC';

  public function label(): string {
    return match($this) {
      static::Registro => 'Registro Civil',
      static::Tarjeta  => 'Tarjeta de Identidad',
      static::Cedula   => 'Cédula de Ciudadanía',
      default          => 'No disponible',
    };
  }//END-label

  public static function caption(): string {
    return 'Tipo de Documento';
  }//END-caption

} //END-ENUM