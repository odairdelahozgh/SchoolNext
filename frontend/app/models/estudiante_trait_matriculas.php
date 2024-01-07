<?php
trait EstudianteTraitMatriculas {
  
  public function getEstadoMat(): EstadoMatricula {
    if ($this->esDeudor()) { return EstadoMatricula::Bloqueado; }
    if (!$this->puedeMatricular()) { return EstadoMatricula::NoPromovido; }
    $Adjuntos = (new EstudianteAdjuntos())::first("SELECT * FROM ".static::getSource()." WHERE estudiante_id=?", [$this->id]);
    $estado_docs = $Adjuntos->getEstadoDocsMatricula($this->grado_mat);

    if (EstadoMatricula::DocAprobados!=$estado_docs) { return $estado_docs; }
    if (strlen($this->numero_mat)==0) { return EstadoMatricula::DocAprobados; }
    if (1!=$this->matricula_firmada) { return EstadoMatricula::FaltaFirmas; }
    return EstadoMatricula::Terminado;
  } //END

  public function esDeudor(): bool {
    return (($this->is_debe_preicfes) or ($this->is_debe_almuerzos) or ($this->mes_pagado!=11));
  } //END
  
  public function puedeMatricular(): bool {
    return (1==$this->is_habilitar_mat);
  } //END

  // public function getLnkAdjuntos(): string {
  //   if ( $this->getEstadoMat() ) {
  //   }
    
  //   return OdaTags::linkButton (
  //     action: "admin/notas/exportBoletinEstudiantePdf/$periodo/$this->uuid", 
  //     text: "<i class=\"fa-solid fa-file-pdf\"></i> P$periodo", 
  //     attrs: "title=\"Descargar Boletín P$periodo $this\" target=\"_blank\" class=\"w3-btn w3-ripple w3-round-large w3-small\"");

  // } //END


} //END-Trait