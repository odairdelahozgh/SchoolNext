<?php

trait AspiranteTraitProps {

  public function __toString() { return "$this->apellido1 $this->apellido2, $this->nombres"; }
  
  public static function is_pago_enum(int $pago, bool $with_color=true, string $attr_class='', bool $show_ico=true) { 
    try {
      return (($show_ico) ? 
              Pagado::tryFrom($pago)->label_ico($with_color, $attr_class) : 
              Pagado::tryFrom($pago)->label($attr_class));
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }

  public function is_pago_f(): string {
    try {
      return self::is_pago_enum((int)$this->is_pago);
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }

} //END-TraitProps