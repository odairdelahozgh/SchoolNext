<?php
  try {
/*     $salida = '<div class="w3-bar">';
    foreach ($data as $key => $estud) {
      $salida .= '<div class="w3-bar-item">
            <span id="btn'.($key+1).'" class="w3-btn w3-large">'.$estud->getFotoCircle().' '.$estud->nombres.'</span>
            </div>';
    }
    return $salida.'</div>'; */

    $ver_matriculas = Config::get('padres.matriculas');
    $ver_seguimientos = Config::get('padres.seguimientos');
    $ver_boletines = Config::get('padres.boletines');
    $ver_planes_apoyo = Config::get('padres.planes_apoyo');
    $ver_reconocimientos = Config::get('padres.reconocimientos');

    echo OdaForm::hidden(field: 'ver_matriculas', value:$ver_matriculas);
    echo OdaForm::hidden(field: 'ver_seguimientos', value:$ver_seguimientos);
    echo OdaForm::hidden(field: 'ver_boletines', value:$ver_boletines);
    echo OdaForm::hidden(field: 'ver_planes_apoyo', value:$ver_planes_apoyo);
    echo OdaForm::hidden(field: 'ver_reconocimientos', value:$ver_reconocimientos);

    $periodo = $arrData['periodo'];
    $buttons = [];
    if (count($data)>0) {
      foreach ($data as $key => $estud) {
        $buttons[$key] = ['caption'=>$estud->getFotoCircle().'<br>'.$estud->nombres, 'action'=>"traer_data($estud->id, '$estud->salon_nombre', $periodo)"];
      }
      return OdaTags::buttonBars(arrButtons: $buttons);
    }
    
  } catch (\Throwable $th) {
    OdaFlash::error($th);
  }

?>
