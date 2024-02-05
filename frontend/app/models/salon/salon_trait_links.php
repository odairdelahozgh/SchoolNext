<?php

trait SalonTraitLinks {
  
  public function getLnkPreboletin(): string {
    try {
      $periodo_actual = Config::get('config.academic.periodo_actual');
      return OdaTags::linkButton(action: "admin/notas/exportBoletinSalonPdf/$periodo_actual/$this->uuid/0", text: 'Preboletin', attrs: " target=\"_blank\" class=\"w3-button w3-green\"");

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getLnkPreboletin
  
  public function getLnkBoletin(): string {
    try {
      $periodo_actual = Config::get('config.academic.periodo_actual');
      return OdaTags::linkButton(action: "admin/notas/exportBoletinSalonPdf/$periodo_actual/$this->uuid/1", text: 'Boletin', attrs: " target=\"_blank\" class=\"w3-button w3-green\"");

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getLnkPreboletin
  
  public function getLnkSetupCalificarSalon(): string {
    try {
      return OdaTags::linkButton(action: "admin/salones/setupCalificarSalon/$this->id", text: 'Setup Cal', attrs: " class=\"w3-button w3-green\"");

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getLnkPreboletin
  

} //END-Trait