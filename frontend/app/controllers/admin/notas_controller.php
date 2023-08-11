<?php
/**
  * Controlador Notas
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class NotasController extends ScaffoldController
{


  function guardarCalificaciones(int $periodo, int $salon_id, int $asignatura_id) {
    $this->page_action = "Guardar Notas";
    $redirect = "docentes/listNotas/$asignatura_id/$salon_id";
    //  var_dump(array_filter($_POST, function($k) {
    //   return $k == 'notas';
    //   }, ARRAY_FILTER_USE_KEY));
    //echo include(APP_PATH.'views/_shared/partials/snippets/show_input_post.phtml');

    try {
      $post_name = 'notas';
      if (!Input::hasPost($post_name)) {
        OdaFlash::warning("No se guardaron los registros. <br>Se esperaba Post <b>$this->nombre_post</b>, no llegó");
      }

      if (Input::hasPost($post_name)) {
        $Post = Input::post($post_name);
        
        // $notas = []; CONTIENE LA INFO ORGANIZADA REGISTRO POR REGISTRO
        $notas = [];
        foreach ($Post as $field_name => $value) {
          $codigo_id = (int)substr($field_name, strripos($field_name, "_") + 1);
          if ($codigo_id>0) { // evitar que se cuele una variable que no sea del registro de calificacion (formato "_$id")
            $notas[$codigo_id][$field_name] = $value;
            if (str_starts_with($field_name, 'profesor_id')) {
              if ( (is_null($value) or (0==$value)) and (1!=$this->user_id)) {
                $notas[$codigo_id][$field_name] = $this->user_id; // reemplace el valor por el usuario actual
              }
            }
          } // else { OdaLog::debug("excluidos $field_name"); }
        }//end-foreach
        
        
        // ----------------------------------------------------------------
        $INDEX_INDCI_INI = 1; $INDEX_INDCI_FIN = 20;  // INDICADORES DE NOTAS 1=>20
        foreach ($notas as $id => $registro) {
          
           // PREPARA EL REGISTRO INDIVIDUAL DE NOTAS
          $data_temp = [];
          foreach ($registro as $field_name_id => $value) {
            $long = strlen($field_name_id) - (strlen($id)+1);
            $field_name = substr($field_name_id,0, $long);
            $data_temp[$field_name] = "$value";
          }
          
          // ORGANIZA LOS INDICADORES
          $cnt_num_ind = 0;
          $data_indicadores = [];
          $data = [];
          foreach ($data_temp as $key => $value) { 
            if (str_starts_with($key, 'i')) { // campos de indicadores
              if (strlen($value)>0) { // indicadores validos
                $indice = $INDEX_INDCI_INI + $cnt_num_ind;
                $index = 'i'.(($indice<10)?'0':'').$indice;
                $data_indicadores[$index] = $value;
                $cnt_num_ind +=1;
              }
            } else {  // campos que no son indicadores
              $data[$key] = $value;
            }
          }
          $data_indicadores = array_unique($data_indicadores); // Elimina indicadores duplicados
          sort($data_indicadores, SORT_NUMERIC); // ordena los indicadores
          $cnt_data_indic = count($data_indicadores); // cuenta de los indicadores que se ingresaron realmente
          // GUARDA LOS INDICADORES REALES Y EN ORDEN
          $indic_i = $INDEX_INDCI_INI;
          foreach ($data_indicadores as $value) { 
            $index = 'i'.(($indic_i<10)?'0':'').$indic_i;
            $data[$index] = $value;
            $indic_i +=1;
          }
          // COMPLETA LOS INDICADORES EN BLANCO hasta $INDEX_INDCI_FIN
          $indic_blank = $indic_i;
          for ($i=$indic_blank; $i<=$INDEX_INDCI_FIN; $i++) {
            $index =  'i'.(($indic_blank<10)?'0':'').$indic_blank;
            $data[$index] = '';
          }

          // SE ASEGURA DE QUE EL VALOR DEL CAMPO "nota_final" SEA CORRECTO
          
          if ( (0==$data['nota_final']) or is_null($data['nota_final']) ) {
            if ( (0==$data['plan_apoyo']) or is_null($data['plan_apoyo']) ) {
              $data['nota_final'] = $data['definitiva'];
            } else {
              $data['nota_final'] = $data['plan_apoyo'];
            }
          } else {
            // cambia la nota final por definitiva ... si no tiene plan de apoyo.
            $data['nota_final'] = ( (0==$data['plan_apoyo']) or is_null($data['plan_apoyo']) ) ? $data['definitiva'] : $data['nota_final'];
          }
          
          // AGREGA CAMPOS ADICIONALES (DE CONTROL)
          $adicionales =[];
          $adicionales['updated_at']= date('Y-m-d H:i:s', time());
          $adicionales['updated_by']= $this->user_id;
          
          // UPDATE SQL PURO
          $Modelo = (new Nota());
          $DQL = new OdaDql($Modelo::class);
          $DQL->update($data)
          ->addUpdate($adicionales)
          ->where("t.id=?")
          ->setParams([$id])
          ->execute();
        } //end-foreach-notas
      }

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
    return Redirect::to(route: $redirect);

  }//END-guardarCalificaciones


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



  public function exportBoletinEstudianteHistPdf(int $annio, int $periodo_id, string $estudiante_uuid): void {
    $tipo_boletin = TBoletin::Boletin;
    $this->arrData['Periodo'] = $periodo_id;

    $Estud = (new Estudiante())->getByUUID($estudiante_uuid);
    $this->arrData['Estud'] = $Estud;
    
    $Salon = (new Salon())::get($Estud->salon_id);
    $this->arrData['Salon'] = $Salon;
    
    //$this->arrData['Grado'] = (new Grado())::get($Salon->grado_id);
    
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
    
    View::select(view: "boletines_hist.pdf", template: null);
  } //END-exportBoletinEstudiantePdf


  public function exportCuadroHonorPrimariaPdf(int $periodo_id): void {
    $this->data = (new Nota())->getCuadroHonorPrimariaPDF($periodo_id);
    $this->file_tipo = 'file-tipo';
    $this->file_name = OdaUtils::getSlug("Cuadro de Honor Primaria PDF-periodo-$periodo_id");
    $this->file_title = "Cuadro de Honor Primaria PDF - Periodo $periodo_id";
    $this->file_download = true;
    View::select(view: "cuadros-de-honor.pdf", template: 'pdf/mpdf');
  } //END-exportCuadroHonorPrimariaPdf


  public function exportCuadroHonorBachilleratoPdf(int $periodo_id): void {
    $this->data = (new Nota())->getCuadroHonorBachilleratoPDF($periodo_id);
    $this->file_tipo = 'file-tipo';
    $this->file_name = OdaUtils::getSlug("Cuadro de Honor Bachillerato PDF-periodo-$periodo_id");
    $this->file_title = "Cuadro de Honor Bachillerato PDF - Periodo $periodo_id";
    $this->file_download = true;
    View::select(view: "cuadros-de-honor.pdf", template: 'pdf/mpdf');
  } //END-exportCuadroHonorBachilleratoPdf

  
  public function exportCuadroHonorGeneralPrimariaPdf(int $periodo_id): void {
    $this->data = (new Nota())->getCuadroHonorGeneralPrimariaPDF($periodo_id);
    $this->file_tipo = 'file-tipo';
    $this->file_name = OdaUtils::getSlug("Cuadro de Honor General Primaria PDF-periodo-$periodo_id");
    $this->file_title = "Cuadro de Honor General Primaria PDF - Periodo $periodo_id";
    $this->file_download = true;
    View::select(view: "cuadros-de-honor-general.pdf", template: 'pdf/mpdf');
  } //END-exportCuadroHonorGeneralPrimariaPdf


  public function exportCuadroHonorGeneralBachilleratoPdf(int $periodo_id): void {
    $this->data = (new Nota())->getCuadroHonorGeneralBachilleratoPDF($periodo_id);
    $this->file_tipo = 'file-tipo';
    $this->file_name = OdaUtils::getSlug("Cuadro de Honor General Bachillerato PDF-periodo-$periodo_id");
    $this->file_title = "Cuadro de Honor General Bachillerato PDF - Periodo $periodo_id";
    $this->file_download = true;
    View::select(view: "cuadros-de-honor-general.pdf", template: 'pdf/mpdf');
  } //END-exportCuadroHonorGeneralBachilleratoPdf

  
} // END CLASS
