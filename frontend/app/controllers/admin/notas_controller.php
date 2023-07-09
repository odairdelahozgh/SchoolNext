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

/*     var_dump(array_filter($_POST, function($k) {
      return $k == 'notas';
      }, ARRAY_FILTER_USE_KEY)); */

    // echo include(APP_PATH.'views/_shared/partials/snippets/show_input_post.phtml');

    try {
      $cnt_success = 0;
      $cnt_fails = 0;
      if (Input::hasPost($this->nombre_post)) {
        $Post = Input::post($this->nombre_post);
        $notas = [];
        foreach ($Post as $field_name => $value) {
          $codigo_id = (int)substr(string: $field_name, offset: strpos(haystack: $field_name, needle: "_") + 1);
          $notas[$codigo_id][$field_name] = $value;
        }

        $Modelo = (new $this->nombre_modelo());
        foreach ($notas as $id => $registro) {
          // PREPARA EL REGISTRO INDIVIDUAL DE NOTAS
          $data = [];
          foreach ($registro as $field_name_id => $value) {
            $long = strlen($field_name_id) - (strlen($id)+1);
            $field_name = substr($field_name_id,0, $long);
            $data[$field_name] = "$value";
          }
          $data = array_unique($data); //Elimina duplicados.
          //asort($data); // FALTA ORDENARLOS
          
          $data['nota_final'] = ($data['nota_final']==0) ? $data['definitiva'] : $data['nota_final'] ;
          
          // ACTUALIZACIÓN DE CADA REGISTRO
          $adicionales =[];
          $adicionales['updated_at']= date('Y-m-d H:i:s', time());
          $adicionales['updated_by']= $this->user_id;

          $DQL = new OdaDql($Modelo::class);
          $DQL->update($data)
              ->addUpdate($adicionales)
              ->where("t.id=?")->setParams([$id]);

          OdaLog::debug("[$id]: ".implode(', ',$data).PHP_EOL.$DQL->render().PHP_EOL.$DQL->getParams());
          
          $success = (new Nota())::query($DQL->render(), [$id])->rowCount() > 0;
          //if ($success) { $cnt_success += 1;}
          if (!$success) { $cnt_fails += 1;}
          
        } //end-foreach-notas
        
        //if ($cnt_fails) { OdaFlash::warning("$this->page_action"); }
        //OdaLog::debug("[$id]: ".implode(', ',array_keys($data)));
        
      }
      return Redirect::to(route: $redirect);

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return Redirect::to(route: $redirect);
    }


  }//END-guardarNotas()

  public function exportBoletinEstudiantePdf(int $periodo_id, string $estudiante_uuid, TBoletin $tipo_boletin=TBoletin::Boletin): void {
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

  public function exportBoletinSalonPdf(int $periodo_id, string $salon_uuid, TBoletin $tipo_boletin = TBoletin::Boletin): void {
    
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
