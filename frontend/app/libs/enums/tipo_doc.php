<?php

enum TipoDoc: string {
  Use EnumsFunciones;

  case Registro = 'RC';
  case Tarjeta  = 'TI';
  case Cedula  = 'CC';

  public function label(bool $abrev = false): string {
    return match($this) {
      static::Registro => (($abrev)?'RC':'Registro Civil'),
      static::Tarjeta  => (($abrev)?'TI':'Tarjeta de Identidad'),
      static::Cedula   => (($abrev)?'CC':'C&eacute;dula de Ciudadan&iacute;a'),
      default          => 'No definido',
    };
  }//END-label

  public static function caption(): string {
    return 'Tipo de Documento';
  }//END-caption

} //END-ENUM