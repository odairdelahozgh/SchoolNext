<?php
/**
  * Controlador Notas
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class NotasController extends ScaffoldController
{
  function guardarCalificaciones(int $periodo, int $salon_id, int $asignatura_id) {
    $this->page_action = "Notas Guardadas";
    $redirect = "docentes/listNotas/$asignatura_id/$salon_id";
    try {

      if (Input::hasPost(var: $this->nombre_post)) {
        $NotasAll = Input::post(var: $this->nombre_post);
        foreach ($NotasAll as $key => $nota) {
          $codigo_id = (int)substr(string: $key, offset: strpos(haystack: $key, needle: "_") + 1);
          //OdaLog::debug(msg: "$periodo / $salon_id / $asignatura_id : $key - $codigo_id");

          $objNota = (new Nota())::get(pk: $codigo_id);

          $objNota->update(data: [
            'definitiva' => $nota->notas_definitiva_.$codigo_id,
            
            'i01' => $nota->notas_i01_.$codigo_id,
            'i02' => $nota->notas_i02_.$codigo_id,
            'i03' => $nota->notas_i03_.$codigo_id,
            'i04' => $nota->notas_i04_.$codigo_id,
            'i05' => $nota->notas_i05_.$codigo_id,
            'i06' => $nota->notas_i06_.$codigo_id,
            'i07' => $nota->notas_i07_.$codigo_id,
            'i08' => $nota->notas_i08_.$codigo_id,
            'i09' => $nota->notas_i09_.$codigo_id,
            'i10' => $nota->notas_i10_.$codigo_id,

            'i11' => $nota->notas_i11_.$codigo_id,
            'i12' => $nota->notas_i12_.$codigo_id,
            'i13' => $nota->notas_i13_.$codigo_id,
            'i14' => $nota->notas_i14_.$codigo_id,
            'i15' => $nota->notas_i15_.$codigo_id,
            'i16' => $nota->notas_i16_.$codigo_id,
            'i17' => $nota->notas_i17_.$codigo_id,
            'i18' => $nota->notas_i18_.$codigo_id,
            'i19' => $nota->notas_i19_.$codigo_id,
            'i20' => $nota->notas_i20_.$codigo_id,
        ]);
        }

        OdaFlash::valid(msg: "$this->page_action :: post = $this->nombre_post");
      }
      return Redirect::to(route: $redirect);

      

    } catch (\Throwable $th) {
      OdaFlash::error(msg: "$this->page_action - ".$th->getMessage(), audit: true);
      OdaLog::debug(msg: $th, name_log: __CLASS__.'-'.__FUNCTION__);
      return Redirect::to(route: $redirect);
    }


  }//END-guardarNotas()

} // END CLASS
