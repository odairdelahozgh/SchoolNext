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

        $Modelo = (new $this->nombre_modelo());
        foreach ($notas as $id => $registro) { // PREPARA EL REGISTRO INDIVIDUAL DE NOTAS
          $data_temp = [];
          foreach ($registro as $field_name_id => $value) {
            $long = strlen($field_name_id) - (strlen($id)+1);
            $field_name = substr($field_name_id,0, $long);
            $data_temp[$field_name] = "$value";
          }

          
          OdaLog::debug('Data temp:   '.implode(', ', $data_temp));
          OdaLog::debug('llaves: '.implode(', ', array_keys($data_temp)));

          $data_unicos = array_unique($data_temp);
          OdaLog::debug('Data unicos: '.implode(', ', $data_unicos));
          OdaLog::debug('llaves: '.implode(', ', array_keys($data_unicos)));

          //asort($data); // FALTA ORDENARLOS

          
          //----------------------------------------------------------------
          // # contar cuántos indicadores quedaron, toca rellenar hasta 20
          $cnt_num_ind = 0;
          foreach ($data_unicos as $key => $value) { 
            if (str_starts_with($key, 'i0')) {
              $cnt_num_ind +=1;
              $index = ($cnt_num_ind<10) ? 'i0'.$cnt_num_ind : 'i'.$cnt_num_ind;
              $data[$index] = $value;
            } else {
              $data[$key] = $value;
            }
          }
          OdaLog::debug('Cnt: '.$cnt_num_ind);

          for ($i=($cnt_num_ind+1); $i<=(20-$cnt_num_ind); $i++) { 
            $index = ($i<10) ? 'i0'.$i : 'i'.$i;
            $data[$index] = '';
          }
          OdaLog::debug('Data final: '.implode(', ', $data));
          OdaLog::debug('llaves: '.implode(', ', array_keys($data)));
          OdaLog::debug('--------------------------------');
          //----------------------------------------------------------------

          //$data_depurada['nota_final'] = ($data_depurada['nota_final']==0) ? $data_depurada['definitiva'] : $data_depurada['nota_final'] ;          
          $adicionales =[];
          $adicionales['updated_at']= date('Y-m-d H:i:s', time());
          $adicionales['updated_by']= $this->user_id;

          $DQL = new OdaDql($Modelo::class);
          $DQL->update($data)
          ->addUpdate($adicionales)
          ->where("t.id=?")
          ->setParams([$id])
          ->execute(true);
          //$success = (new Nota())::query($DQL->render(), [$id])->rowCount() > 0;
          //if (!$success) { $cnt_fails += 1;}
          
          //OdaLog::debug("[$id]: ".implode(', ',$data).PHP_EOL.$DQL->render().PHP_EOL.$DQL->getParams());
        } //end-foreach-notas
        //if ($cnt_fails) { OdaFlash::warning("$this->page_action"); }
      }
      return Redirect::to(route: $redirect);

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return Redirect::to(route: $redirect);
    }

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
