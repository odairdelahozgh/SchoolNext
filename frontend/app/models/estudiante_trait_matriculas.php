<?php
trait EstudianteTraitMatriculas {
  
  public function getEstadoMat(): EstadoMatricula 
  {
    if ($this->esDeudor()) { 
      return EstadoMatricula::Bloqueado; 
    }
    if (!$this->puedeMatricular()) { 
      return EstadoMatricula::NoPromovido; 
    }
    
    $Adjuntos = (new EstudianteAdjuntos())::first("SELECT * FROM ".static::getSource()." WHERE estudiante_id=?", [$this->id]);
    $estado_docs = $Adjuntos->getEstadoDocsMatricula($this->grado_mat);

    if (EstadoMatricula::DocAprobados != $estado_docs) { 
      return $estado_docs; // Atascado en revisión de documentos
    }

    if ( empty($this->numero_mat) ) { 
      return EstadoMatricula::DocAprobados; // Aprobados pero sin firmas de documentos
    }

    return EstadoMatricula::Terminado;
  }

  public function esDeudor(): bool 
  {
    return (($this->is_debe_preicfes) or ($this->is_debe_almuerzos) or ($this->mes_pagado!=11));
  }
  
  public function puedeMatricular(): bool 
  {
    return (1==$this->is_habilitar_mat);
  }
  
  public function numero_mat_f(): string
  {
    if ( empty($this->numero_mat) ) {
      return '';
    }
    return str_pad($this->numero_mat, 4, '0', STR_PAD_LEFT);
  }



}