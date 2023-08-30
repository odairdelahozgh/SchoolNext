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

  
  public static function indicadorF(int $indicador=101, $ListaIndicadores) {
    if (0==$indicador) {
      return '';
    }
    if (!is_null($ListaIndicadores)) {
      if (array_key_exists($indicador, $ListaIndicadores)) {
        $valorativo = Valorativo::tryFrom( $ListaIndicadores[$indicador]['valorativo'][0] );
        return "
          <span 
            title=\"[$indicador] {$ListaIndicadores[$indicador]['concepto']}\"
            class=\"w3-tag w3-round w3-{$valorativo->color()} w3-border w3-border-white\">
              $indicador
          </span>";
      } else {
        return "<span>$indicador</span>";
      }
    }
    return "<span>$indicador</span>";    
  } //END-indicadorF


} //END-TRAIT