<?php
/**
 * Modelo Grado 
 *  
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * 'id', 'uuid', 'annio', 'periodo_id', 'grado_id', 'asignatura_id', 'codigo', 'concepto', 'valorativo', 'is_visible', 'is_active', 'created_at', 'updated_at', 'created_by', 'updated_by'
 */
  
 trait GradoTraitProps {

  public function __toString() { return $this->nombre; }

  public static function getGradosArray() { 
    $arrResult = [];
    foreach ((new Grado())->getList(1) as $grado) { $arrResult[$grado->id] = $grado->nombre; }
    return $arrResult;
  } //END-getGradosArray


  public static function getSelectGrados(string $id, string $name, int $grado_selected_id=0): string { 
    $listaGrados = (new Grado())->getList(1);
    $opts = '';
    $secc_ant = 0;
    foreach ($listaGrados as $key => $grado) {
      if ($grado->seccion_id <> $secc_ant) {
        $opts .= ((0==$key) ? "<optgroup label=\"$grado->seccion\">" : "</optgroup><optgroup label=\"$grado->seccion\">");
      }
      $grado_sel = ($grado->id == $grado_selected_id) ? 'selected' : '' ;
      $opts .= "<option value=\"$grado->id\" $grado_sel>$grado->nombre</option>";
      $secc_ant = $grado->seccion_id;
    }
    return "<select id=\"$id\" name=\"$name\"  class=\"w3-input w3-border\">$opts</select>";
  } //END-getSelectGrados

} //END-TRAIT