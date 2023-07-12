<?php

trait SalonTraitLinks {
  
  public function getLnkPreboletin(): string {
    try {
      $periodo_actual = Config::get('config.academic.periodo_actual');
      return OdaTags::linkButton(action: "admin/notas/exportBoletinSalonPdf/$periodo_actual/$this->uuid/0", text: 'Preboletin');

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getLnkPreboletin
  
  public function getLnkBoletin(): string {
    try {
      $periodo_actual = Config::get('config.academic.periodo_actual');
      return OdaTags::linkButton(action: "admin/notas/exportBoletinSalonPdf/$periodo_actual/$this->uuid/1", text: 'Boletin');

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getLnkPreboletin
  
} //END-Trait