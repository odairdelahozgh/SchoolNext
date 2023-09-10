<?php

trait NotaTraitCorrecciones {

  public static function generarCalif_BySalonAsignatura(int $salon_id=1, int $asignatura_id=1) {
    $Estudiantes = (new Estudiante())::filter( 'SELECT * FROM swb_estudiantes WHERE salon_id=?', [$salon_id] );
    if ($Estudiantes) {
      foreach ($Estudiantes as $key => $Estud) {
        echo "$Estud :: $Estud->id<br>";
      }
    } else {
      OdaFlash::info('No hay registros');
    }
  }

} //END-Trait