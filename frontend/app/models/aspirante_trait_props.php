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

  public function is_pago_f() {
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

  public function estatus_f(): string 
  {
    return self::estatus_enum((string)$this->estatus);
  }


  
  public static function ctrl_llamadas_enum(string $ctrl_llamadas, bool $with_color=true, string $attr_class='', bool $show_ico=true) { 
    try {
      return (
        ($show_ico) ? 
        AspirLlamadas::tryFrom($ctrl_llamadas)->label_ico($with_color, $attr_class) : 
        AspirLlamadas::tryFrom($ctrl_llamadas)->label($attr_class)
      );
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-estatus_enum


  public function ctrl_llamadas_f() {
    try {
      return self::ctrl_llamadas_enum((string)$this->ctrl_llamadas);
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-ctrl_llamadas_f


  public function lnkPageEditAspirantePsicologia(): string {
    try {
      return OdaTags::link(
        action: "sicologia/admisiones_edit/$this->id",
        text: "$this",
      );
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }//END-lnkPageEditAspirantePsicologia

  
  public function lnkPageEditAspiranteSecretaria(): string {
    try {
      return OdaTags::link(
        action: "secretaria/admisiones_edit/$this->id",
        text: "$this",
      );
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }//END-lnkPageEditAspiranteSecretaria



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

  public function lnkTrasladar(): string {
    return OdaTags::link(
      action: "admin/aspirantes/trasladar/{$this->id}",
      text: "Admitido",
      attrs: 'style="color:seagreen"',
    );
  }


} //END-TraitProps