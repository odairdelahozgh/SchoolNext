<?php
enum TBoletin: int {
  Use EnumsFunciones;
  case Preboletin = 0;
  case Boletin   = 1;

  public function label(bool $abrev = false): string {
    return match($this) {
      static::Preboletin => (($abrev)?'PBo':'Prebolet&iacute;n'),
      static::Boletin    => (($abrev)?'Bol':'Bolet&iacute;n'),
      default            => throw new InvalidArgumentException(message: "{$this->caption()} Erroneo"),
    };
  }//END-label
  
  public static function caption(): string {
    return 'Tipo de bolet&iacute;n acad&eacute;mico';
  }//END-caption

} //END-ENUM