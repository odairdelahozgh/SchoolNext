<?php
/**
 * Modelo 
 *  
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */
  
 trait GradoTraitProps {

  public function __toString() { return $this->nombre; }
  public function getIsPrescolar() { return ( 1 == $this->seccion_id ) ? 'X': ''; }
  public function getIsPrimaria() { return ( 2 == $this->seccion_id ) ? 'X': ''; }
  public function getIsMediaAcademica() { return ( 3 == $this->seccion_id ) ? 'X': ''; }
  public function getIsBasicaSecundaria() { return ( 4 == $this->seccion_id ) ? 'X': ''; }
  public function getIsBachillerato() { return ( ( 3 == $this->seccion_id or 4 == $this->seccion_id ) ? 'X': ''); }
  
  // COSTOS DE MATRICULA
   
  // =======================================================================
  // RELATIVOS A LA TABLA Grado
  public function getValorPension($lim=0) { 
    $pension_ord = $this->valor_pension;
    switch ($lim) {
      case 0: // 0: Ordinaria
        $pension = $pension_ord;
        break;

      case 1: // 1: Extemporanea 1
        $pension = round($pension_ord*1.02,-2);
        break;

      case 2: // 2: Extemporanea 2
        $pension = round($pension_ord*1.04,-2);
        break;

      case 3: // 3: Extemporanea 3
        $pension = round($pension_ord*1.06,-2);
        break;

      case 4: // 4: Extemporanea 4
        $pension = round($pension_ord*1.08,-2);
        break;
        
      default:
        $pension = $pension_ord;
        break;
    }
    return $pension;
  }

  // --------------
  public function getValorPensionF($lim=0) { 
    return '$'.number_format($this->getValorPension($lim), 0, ',', '.'); 
  }
  // --------------
  public function getValorMatricula($ordinaria=1) { 
    if ($ordinaria==1) {
      return $this->valor_matricula;
    } else {
      return $this->valor_matricula+100000;
    }
  }
  public function getValorMatriculaF($ordinaria=1): string { 
    return '$'.number_format($this->getValorMatricula($ordinaria), 0, ',', '.'); 
  }
  // --------------
  public function getCostoAnualMatricula($ordinaria=1) {
    return $this->getValorPension()*10 + $this->getValorMatricula($ordinaria);
  }
  public function getCostoAnualMatriculaF($ordinaria=1): string { 
    return '$'.number_format($this->getCostoAnualMatricula($ordinaria), 0, ',', '.'); 
  }
  public function getCostoAnualMatriculaPalabras($ordinaria=1): string { 
    return $this->valor_letras($this->getCostoAnualMatricula($ordinaria));
  }


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