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

    //  var_dump(array_filter($_POST, function($k) {
    //   return $k == 'notas';
    //   }, ARRAY_FILTER_USE_KEY));
    //echo include(APP_PATH.'views/_shared/partials/snippets/show_input_post.phtml');

    try {
      //$cnt_success = 0; 
      $cnt_fails = 0;
      if (Input::hasPost($this->nombre_post)) {
        $Post = Input::post($this->nombre_post);
        $notas = [];
        foreach ($Post as $field_name => $value) {
          $codigo_id = (int)substr(string: $field_name, offset: strpos(haystack: $field_name, needle: "_") + 1);
          if ($codigo_id>0) { // evitar que se cuele una variable que no sea del registro de calificacion (formato "_$id")
            $notas[$codigo_id][$field_name] = $value;
          }
        }//end-foreach

        
        foreach ($notas as $id => $registro) { // PREPARA EL REGISTRO INDIVIDUAL DE NOTAS
          $data_temp = [];
          foreach ($registro as $field_name_id => $value) {
            $long = strlen($field_name_id) - (strlen($id)+1);
            $field_name = substr($field_name_id,0, $long);
            $data_temp[$field_name] = "$value";
          }
          $dt_debug = '';
          //if (4138==$id) {
          //  $dt_debug .= 'Data Temp: '.implode(', ', $data_temp).PHP_EOL;
          //  $dt_debug .= 'Data Temp keys: '.implode(', ', array_keys($data_temp)).PHP_EOL.PHP_EOL;
          //}
          
          $cnt_num_ind = 0;
          $data_indicadores = [];
          $data = [];
          foreach ($data_temp as $key => $value) { 
            if (str_starts_with($key, 'i')) { // campos de indicadores
              if (strlen($value)>0) { // indicadores validos
                $cnt_num_ind +=1;
                $index = ($cnt_num_ind<10) ? 'i0'.$cnt_num_ind : 'i'.$cnt_num_ind;
                $data_indicadores[$index] = $value;
              }
            } else {  // campos que no son indicadores
              $data[$key] = $value;
            }
          }
          // if (4138==$id) {
          //   $dt_debug .= 'Data indicadores: '.implode(', ', $data_indicadores).PHP_EOL;
          //   $dt_debug .= 'Data indicadores keys: '.implode(', ', array_keys($data_indicadores)).PHP_EOL.PHP_EOL;
          //   $dt_debug .= 'Data: '.implode(', ', $data).PHP_EOL.PHP_EOL;
          // }

          $data_indicadores = array_unique($data_indicadores); // elimina indicadores duplicados
          // if (4138==$id) {
          //   $dt_debug .= 'Data indicadores sin duplicados : '.implode(', ', $data_indicadores).PHP_EOL;
          //   $dt_debug .= 'Data indicadores sin duplicados keys: '.implode(', ', array_keys($data_indicadores)).PHP_EOL.PHP_EOL;
          // }

          sort($data_indicadores, SORT_NUMERIC); // los ordena
          // if (4138==$id) {
          //   $dt_debug .= 'Data indicadores sin duplicados y ordenados: '.implode(', ', $data_indicadores).PHP_EOL;
          //   $dt_debug .= 'Data indicadores sin duplicados y ordenados keys: '.implode(', ', array_keys($data_indicadores)).PHP_EOL.PHP_EOL;
          // }
          
          $cnt_num_ind = 0;
          foreach ($data_indicadores as $value) { 
            $cnt_num_ind +=1;
            $index = ($cnt_num_ind<10) ? 'i0'.$cnt_num_ind : 'i'.$cnt_num_ind;
            $data[$index] = $value;
          }
          // if (4138==$id) {
          //   $dt_debug .= 'Data : '.implode(', ', $data).PHP_EOL;
          //   $dt_debug .= 'Data keys: '.implode(', ', array_keys($data)).PHP_EOL.PHP_EOL;
          // }

          $cnt_num_ind +=1;
          for ($i=$cnt_num_ind; $i<=20; $i++) { // COMPLETA LOS INDICADORES EN BLANCO
            $index = ($i<10) ? 'i0'.$i : 'i'.$i;
            $data[$index] = ' ';
          }
          // if (4138==$id) {
          //   $dt_debug .= 'Data FINAL: '.implode(', ', $data).PHP_EOL;
          //   $dt_debug .= 'Data FINAL keys: '.implode(', ', array_keys($data)).PHP_EOL.PHP_EOL;
          // }

          //if (4138==$id) {
          //  OdaLog::debug(str_repeat('-', 15).PHP_EOL.$dt_debug);
          //}
          $adicionales =[];
          $adicionales['updated_at']= date('Y-m-d H:i:s', time());
          $adicionales['updated_by']= $this->user_id;
          
          
          $data['nota_final'] = (0==$data['nota_final']) ? $data['definitiva'] : $data['nota_final'] ;

          $Modelo = (new $this->nombre_modelo());
          $DQL = new OdaDql($Modelo::class);
          $DQL->update($data)
          ->addUpdate($adicionales)
          ->where("t.id=?")
          ->setParams([$id])
          ->execute();

          // if (4138==$id) {
          //   OdaLog::debug(str_repeat('=', 15).PHP_EOL.$DQL->render());
          // }
          //$success = (new Nota())::query($DQL->render(), [$id])->rowCount() > 0;
          //if (!$success) { $cnt_fails += 1;}
          
          //OdaLog::debug("[$id]: ".implode(', ',$data).PHP_EOL.$DQL->render().PHP_EOL.$DQL->getParams());
        } //end-foreach-notas
        //if ($cnt_fails) { OdaFlash::warning("$this->page_action"); }

      }

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
    return Redirect::to(route: $redirect);

  }//END-guardarNotas()


  public function exportBoletinEstudiantePdf(int $periodo_id, string $estudiante_uuid, int $tipo = 1): void {
    $tipo_boletin = TBoletin::tryFrom($tipo) ?? TBoletin::Boletin;
    $this->arrData['Periodo'] = $periodo_id;
    $Estud = (new Estudiante())->getByUUID($estudiante_uuid);
    $this->arrData['Estud'] = $Estud;
    $Salon = (new Salon())::get($Estud->salon_id);
    $this->arrData['Salon'] = $Salon;
    $this->arrData['Grado'] = (new Grado())::get($Salon->grado_id);
    
    $this->arrData['Docentes'] = [];
    foreach ((new Empleado())->getList() as $empleado) {
      $this->arrData['Docentes'][$empleado->id] = $empleado;
    }

    $this->data = (new Nota())->getByPeriodoEstudiante($periodo_id, $Estud->id);
    $Indicadores = (new Indicador())->getByPeriodoGrado($periodo_id, $Salon->grado_id);
    foreach ($Indicadores as $key => $indic) {
      $val = strtoupper(substr($indic->valorativo,0,1));
      $this->arrData [ 'Indicadores' ] [ $indic->asignatura_id ] [ $indic->codigo ] ['concepto'] = $val.':'.trim($indic->concepto);
    }
    $this->file_tipo = $tipo_boletin->label();
    $this->file_name = OdaUtils::getSlug($tipo_boletin->label()."-de-$Estud-periodo-$periodo_id");
    $this->file_title = $tipo_boletin->label()." de Notas $Estud";
    
    View::select(view: "boletines.pdf", template: null);
  } //END-exportBoletinEstudiantePdf


  public function exportBoletinSalonPdf(int $periodo_id, string $salon_uuid, int $tipo = 1): void {
    $tipo_boletin = TBoletin::tryFrom($tipo) ?? TBoletin::Boletin;

    $this->arrData['Periodo'] = $periodo_id;
    $Salon = (new Salon())->getByUUID($salon_uuid);

    $this->arrData['Salon'] = $Salon;
    $this->arrData['Grado'] = (new Grado())::get($Salon->grado_id);
    
    $this->arrData['Docentes'] = [];
    foreach ((new Empleado())->getList() as $empleado) {
      $this->arrData['Docentes'][$empleado->id] = $empleado;
    }

    $this->data = (new Nota())->getByPeriodoSalon($periodo_id, $Salon->id);
    $Indicadores = (new Indicador())->getByPeriodoGrado($periodo_id, $Salon->grado_id);
    foreach ($Indicadores as $key => $indic) {
      $val = strtoupper(substr($indic->valorativo,0,1));
      $this->arrData [ 'Indicadores' ] [ $indic->asignatura_id ] [ $indic->codigo ] ['concepto'] = $val.':'.$indic->concepto;
    }
    
    // PARA LA GENERACIÓN DE ARCHIVOS
    $this->file_tipo = $tipo_boletin->label();
    $this->file_name = OdaUtils::getSlug($tipo_boletin->label()."-de-$Salon-periodo-$periodo_id");
    $this->file_title = $tipo_boletin->label() .' de ' .$Salon;

    View::select(view: "boletines.pdf", template: null);
  } //END-exportBoletinSalonPdf



} // END CLASS
