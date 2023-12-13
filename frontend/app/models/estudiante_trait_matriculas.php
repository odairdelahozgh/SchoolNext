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
  } //END-getEstadoMat

  public function esDeudor(): bool {
    return (($this->is_debe_preicfes) or ($this->is_debe_almuerzos) or ($this->mes_pagado!=11));
  }
  
  public function puedeMatricular(): bool {
    return (1==$this->is_habilitar_mat);
  }

} //END-Trait