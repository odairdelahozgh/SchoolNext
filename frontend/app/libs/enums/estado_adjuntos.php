<?php

enum EstadoAdjuntos: string {
  Use EnumsFunciones;
  case Revision  = 'En Revisión';
  case Rechazado = 'Rechazado';
  case Aprobado  = 'Aprobado';

  public function label(bool $abrev = false): string {
    return match($this) {
      static::Revision  => 'Archivo en Revisión',
      static::Rechazado => 'Archivo Rechazado',
      static::Aprobado  => 'Archivo Aprobado',
      default  => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label

  public static function caption(): string {
    return 'Estado de Archivo Adjunto';
  }//END-caption

} //END-ENUM