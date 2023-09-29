<?php

enum AspirLlamadas: string {
  Use EnumsFunciones;

  case Pendiente   = 'No Notificado';
  case AExamen     = 'Examen';
  case AEntrevista = 'Entrevista';
  case AResultados = 'Resultados';

  public function label(bool $abrev = false): string {
    return match($this) {
      static::Pendiente   => 'No notificado',
      static::AExamen     => 'Llamado para Examen',
      static::AEntrevista => 'Llamado para Entrevista',
      static::AResultados => 'Llamado para Resultados',
      default             => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label

  public function ico(bool $with_color=true, $attr_class=''): string {
    $ico = match($this) {
        static::Pendiente   => 'fa-',
        static::AExamen     => 'fa-',
        static::AEntrevista => 'fa-',
        static::AResultados => 'fa-',
        default             => 'fa-question',
    };
    $color = ($with_color) ? 'style="color: '.self::color().'"' : '' ;
    return "<i class=\"fa-solid $ico $attr_class\" $color></i>&nbsp;";
  } //END-ico
  
  public function color(): string {
    return match($this) {
        static::Pendiente   => 'red',
        static::AExamen     => 'blue',
        static::AEntrevista => 'orange',
        static::AResultados => 'green',
        default             => 'red',
    };
  }//END-color


  public function label_ico(bool $with_color=true, $attr_class=''): string {
    return $this->ico($with_color, $attr_class).$this->label($attr_class);
  } //END-label_ico


  public static function caption(): string {
    return 'Control de Llamadas';
  }//END-caption

} //END-ENUM