<?php
enum EstadoMatricula: int {
  Use EnumsFunciones;

  case Bloqueado = 0;
  case NoPromovido = 1;
  case SinDocumentos = 2;
  case DocIncompletos = 3;
  case DocEnRevision = 4;
  case DocRechazados = 5;
  case DocAprobados = 6;
  case FaltaFirmas = 7;
  case Terminado = 8;
  
  public function label(): string {
    return match($this) {
      static::Bloqueado       => 'Bloqueado x Contabilidad',
      static::NoPromovido     => 'Estudiante No Promovido', // estan pendientes de notas 
      static::SinDocumentos   => 'No ha subido Documentos',
      static::DocIncompletos  => 'Documentos INCOMPLETOS',
      static::DocEnRevision   => 'Documentos EN REVISIÓN',
      static::DocRechazados   => 'Documentos RECHAZADOS',
      static::DocAprobados    => 'Documentos APROBADOS, Falta ASIGNAR NÚMERO DE MATRÍCULA',
      static::FaltaFirmas     => 'Documentos APROBADOS, Falta FIRMAS DE ACEPTACIÓN del Acudiente',
      static::Terminado       => 'Proceso Terminado',
      default => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label

  public function ico(): string {
    return ''; // "<i class=\"fa-solid fa-calendar-day w3-small\"></i>&nbsp;";
  }//END-ico
  
  public function label_ico(): string {
    return $this->ico().$this->label();
  }

  public static function caption(): string {
    return 'Estado del Proceso de Matriculas';
  }//END-caption

} // END-ENUM