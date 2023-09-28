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
  } //END-is_pago_enum

  public function is_pago_f(): string {
    try {
      return self::is_pago_enum((int)$this->is_pago);
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-is_pago_f

  public static function estatus_enum(string $estatus, bool $with_color=true, string $attr_class='', bool $show_ico=true) { 
    try {
      return (($show_ico) ? 
        AspirEstatus::tryFrom($estatus)->label_ico($with_color, $attr_class) : 
        AspirEstatus::tryFrom($estatus)->label($attr_class));
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-estatus_enum

  public function estatus_f(): string {
    try {
      return self::estatus_enum((string)$this->estatus);
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-is_pago_f


  public function lnkPageEditAspirante(): string {
    try {
      return OdaTags::link(
        action: "sicologia/admisiones_edit/$this->id",
        text: "$this",
        //attrs: 'class="btn"',
      );
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }//END-lnkPageEditAspirante


  public function fecha_entrev_f() {
    $timezone = new DateTimeZone("America/Bogota");
    $date = new DateTimeImmutable($this->fecha_entrev, $timezone);
    return ( ($this->fecha_entrev=='0000-00-00 00:00:00') ? '' : $date->format('M-d H:iA'));
  } //END-fecha_entrev_f
  
  
  public function fecha_eval_f() {
    $timezone = new DateTimeZone("America/Bogota");
    $date = new DateTimeImmutable($this->fecha_eval, $timezone);
      return ( ($this->fecha_eval=='0000-00-00 00:00:00') ? '' : $date->format('M-d H:iA'));
  } //END-fecha_eval_f


} //END-TraitProps