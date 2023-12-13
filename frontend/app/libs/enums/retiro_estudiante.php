<?php

enum RetiroEstudiante: string {
  Use EnumsFunciones;
  case Voluntario  = 'Voluntario';
  case Institucion = 'Institución';
  case Graduacion  = 'Graduación';

  public function label(bool $abrev = false): string {
    return match($this) {
      static::Voluntario  => 'Retiro Voluntario',
      static::Institucion => 'Retiro Institución',
      static::Graduacion  => 'Se Graduó',
      default  => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label

  public function color(): string {
    return match($this) {
        static::Voluntario  => 'blue',
        static::Institucion => 'red',
        static::Graduacion  => 'green',
        default             => 'red',
    };
  }//END-color


  public static function caption(): string {
    return 'Tipo Retiro Estudiante';
  }//END-caption

} //END-ENUM