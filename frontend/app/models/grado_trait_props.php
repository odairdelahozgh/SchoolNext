<?php
/*
id, uuid, proximo_grado, salon_default, nombre, abrev, seccion_id, orden, valor_matricula, matricula_palabras, valor_pension, 
pension_palabras, proximo_salon, created_by, updated_by, created_at, updated_at, is_active
*/

trait GradoTraitProps {
  /*
  */ 
  public function __toString() { return $this->nombre; }
  
} //END-TraitProps