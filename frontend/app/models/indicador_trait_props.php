<?php
/**
 * Modelo Indicador * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * 'id', 'uuid', 'annio', 'periodo_id', 'grado_id', 'asignatura_id', 'codigo', 'concepto', 'valorativo', 'is_visible', 'is_active', 'created_at', 'updated_at', 'created_by', 'updated_by'
 */
  
 trait IndicadorTraitProps {

  public function __toString() { return $this->codigo; }

} //END-TRAIT