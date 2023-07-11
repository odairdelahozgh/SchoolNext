<?php
  try {
/*     $salida = '<div class="w3-bar">';
    foreach ($data as $key => $estud) {
      $salida .= '<div class="w3-bar-item">
            <span id="btn'.($key+1).'" class="w3-btn w3-large">'.$estud->getFotoCircle().' '.$estud->nombres.'</span>
            </div>';
    }
    return $salida.'</div>'; */

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
