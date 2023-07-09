<?php
enum TBoletin: int {
  Use EnumsFunciones;
  case Preboletin = 0;
  case Boletin   = 1;

  public function label(): string {
    return match($this) {
      static::Preboletin => 'Preboletín',
      static::Boletin    => 'Boletín',
      default            => 'Preboletín',
    };
  }//END-label
  
} //END-ENUM