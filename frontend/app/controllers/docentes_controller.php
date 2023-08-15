<?php
/**
  * Controlador Docentes  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */

require_once APP_PATH . '../vendor/autoload.php';
//use Mpdf\Mpdf;

class DocentesController extends AppController
{

  public function index() {
    $this->page_action = 'Inicio';
    $this->data = (new Evento)->getEventosDashboard();
  }//END-index


  public function carga(): void { // Carga Académica de Profesor
    try {
      $this->page_action = 'Carga Acad&eacute;mica';
      $this->data = (new SalAsigProf)->getCarga($this->user_id);

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }//END-carga

  
  /**
   * $data: ASIGNAR Carga Académica de Profesor
   */
  public function asignar_carga(): void {
    try {
      $this->page_action = 'Asignar Carga Acad&eacute;mica';
      $usuario = $this->user_id;
  
      if (1==$usuario) { // admin
        $sap = (new SalAsigProf)::first("SELECT sap.user_id as ultimo_user_id FROM ".Config::get('tablas.salon_asignat_profe')." AS sap WHERE sap.id =(SELECT MAX(sapm.id) as max  FROM ".Config::get('tablas.salon_asignat_profe')." AS sapm)");
        $usuario = $sap->ultimo_user_id;
      }
      $this->data = (new SalAsigProf)->getCarga($this->user_id); // siempre la carga del usuario logeado
      $this->arrData[0] = $usuario;
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-asignar_carga

  
  public function direccion_grupo(): void {
    try {
      $this->page_action = 'Direcci&oacute;n de Grupo';
      $periodo = Session::get('periodo');

      $this->data = (new usuario)->misGrupos(); //($this->user_id

      for ($i=1; $i <=$periodo ; $i++) { 
        $a_regs = (new Nota)::getNotasPromAnnioPeriodoSalon($i, $this->data[0]->id);
        foreach ($a_regs as $key => $value) {
          $this->arrData[$value->asignatura_nombre][$i]['avg'] = $value->avg;
        }
        //$this->a_prom_p[$i]  = array_prom_key($a_regs, 'avg' );
      }

      $this->buttons = [];
      foreach ($this->data as $key => $salon) {
        $this->buttons[$key] = ['caption'=>$salon, 'action'=>"traer_data($salon->id)"];
      }
      
      } catch (\Throwable $th) {
        OdaFlash::error($th);
      }

      View::select('direccionDeGrupo/index');
  }//END-direccion_grupo


  public function registros_observaciones(): void {
    try {
      $this->page_action = 'Registros de Observaciones Generales';
      $estudiantes = (new Estudiante)->getListEstudiantes(estado: 1);
      $this->arrData = ['estudiantes' => $estudiantes];

      $this->data = (new RegistrosGen)->getRegistrosProfesor(user_id: Session::get(index: 'id'));

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
    View::select('registrosObservGenerales/index');
  }//END-registros_observaciones
  
  
  public function registros_desemp_acad(): void {  // Registros de desempeño academico
    try {
      $this->page_action = 'Registros de Desempeño Académico';
      $estudiantes = (new Estudiante)->getListEstudiantes(estado: 1);
      $this->arrData = ['estudiantes' => $estudiantes];
      
      $this->data = (new RegistroDesempAcad)->getRegistrosProfesor(user_id: Session::get(index: 'id'));
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }

    View::select('registrosDesempAcad/index');
  } //END-registros_observaciones


  public function listIndicadores(int $grado_id, int $asignatura_id): void {
    try {
      $this->page_action = 'Indicadores de Logro';
      $RegGrado = (new Grado)->get($grado_id);
      $RegAsignatura = (new Asignatura)->get($asignatura_id);
      $this->arrData = ['grado' => $RegGrado, 'asignatura' => $RegAsignatura];
    }
    catch (\Throwable $th) {
      OdaFlash::error($th);
    }
    // $arrIndic = array( 1=>array(), 2=>array(), 3=>array(), 4=>array(), 5=>array() );
    // foreach ($indicadores as $indic) {
    //   array_push($arrIndic[$indic->periodo_id], $indic);
    // }
    //$this->data = $arrIndic;

    View::select(view: 'indicadores/index');
  }//END-indicadores


  /**
   * notas/list
   */
  public function listNotas(int $asignatura_id, int $salon_id): void {
    try {  
      $this->page_action = 'Notas del Sal&oacute;n';
      
      $this->Asignatura = (new Asignatura)->get($asignatura_id);
      $this->Salon= (new Salon)->get($salon_id);
      
      $arr_periodos = range(start: 1, end: $this->_periodo_actual);

      $Notas = (new Nota)->getBySalonAsignaturaPeriodos($salon_id, $asignatura_id, $arr_periodos);
      if (0==count($Notas)) { 
        OdaFlash::info('No hay registros para mostrar.');
      }

      $this->data = array( 1=>array(), 2=>array(), 3=>array(), 4=>array(), 5=>array() );
      foreach ($Notas as $key => $nota) {
        array_push($this->data[$nota->periodo_id], $nota);
      }
      
    } catch (\Throwable $th) {
      OdaFlash::error($th, true);
    }

    View::select(view: 'notas/list');
  }//END-notas


  public function notasCalificar(int $periodo_id, int $salon_id, int $asignatura_id): void {
    try {
      $this->page_action = 'Calificar Notas del Sal&oacute;n';
      $RegSalon = (new Salon)->get($salon_id);
      $RegPeriodo =(new Periodo)->get($periodo_id);
      $RegAsignatura = (new Asignatura)->get($asignatura_id);

      $Nota = new Nota();
      $this->data = $Nota->getBySalonAsignaturaPeriodos(salon_id: $salon_id, asignatura_id: $asignatura_id, periodos: [$periodo_id]);
      $RegsIndicad = (new Indicador)->getIndicadoresCalificar(periodo_id: $periodo_id, grado_id: $RegSalon->grado_id, asignatura_id: $asignatura_id);
      
      $min_fortaleza = 0;
      if ($RegsIndicad) {
        $regs_min = min($RegsIndicad) ?? 0;
        $regs_max = max($RegsIndicad) ?? 0;
        
        $min_fortaleza = min(array_filter(array: $RegsIndicad, callback: function ($element): bool {
          return $element->valorativo == 'Fortaleza';
        }));
        $max_fortaleza = max(array_filter(array: $RegsIndicad, callback: function ($element) {
          return $element->valorativo == 'Fortaleza';
        }));
        
        $min_debilidad = min(array_filter(array: $RegsIndicad, callback: function ($element) {
          return $element->valorativo == 'Debilidad';
        }));
        $max_debilidad = max(array_filter(array: $RegsIndicad, callback: function ($element) {
          return $element->valorativo == 'Debilidad';
        }));
        
        $min_recomendacion = min(array_filter(array: $RegsIndicad, callback: function ($element) {
          return $element->valorativo == 'Recomendación';
        }));
        $max_recomendacion = max(array_filter(array: $RegsIndicad, callback: function ($element) {
          return $element->valorativo == 'Recomendación';
        }));
      }

      
      $this->fieldsToShow = $Nota::getFieldsShow(show: 'calificar');
      $this->arrData = [
        'Periodo'           => $RegPeriodo,
        'Asignatura'        => $RegAsignatura,
        'Salon'             => $RegSalon,
        'Indicadores'       => $RegsIndicad,
        'annio_actual'      => (int)Config::get(var: 'config.academic.annio_actual'),
        'periodo_actual'    => (int)Config::get(var: 'config.academic.periodo_actual'),
        'min_fortaleza'     =>$min_fortaleza,
        'max_fortaleza'     =>$max_fortaleza,
        'min_debilidad'     =>$min_debilidad,
        'max_debilidad'     =>$max_debilidad,
        'min_recomendacion' =>$min_recomendacion,
        'max_recomendacion' =>$max_recomendacion,
        'min_indic' => $regs_min,
        'max_indic' => $regs_max,
        'cnt_indicador'   =>count(value: $RegsIndicad),
      ];
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
    View::select(view: 'notas/calificar/index');
  }//END-notas


  public function notasCalificarSeguimientos(int $periodo_id, int $salon_id, int $asignatura_id): void {
    try {
      $this->page_action = 'Seguimientos Intermedios del Sal&oacute;n';
      $RegSalon = (new Salon)->get($salon_id);
      $RegPeriodo =(new Periodo)->get($periodo_id);
      $RegAsignatura = (new Asignatura)->get($asignatura_id);
      
      $SegInt = new Seguimientos();
      $this->data = $SegInt->getBySalonAsignaturaPeriodos($salon_id, $asignatura_id, [$periodo_id]);

      $RegsIndicad = (new Indicador)->getIndicadoresCalificar(periodo_id: $periodo_id, grado_id: $RegSalon->grado_id, asignatura_id: $asignatura_id);
      $MinMaxIndicad = (new Indicador)->getMinMaxByPeriodoGradoAsignatura($periodo_id, $RegSalon->grado_id, $asignatura_id);
      
      $regs_min = 0;
      $regs_max = 0;
      
      $min_fortaleza = 0;
      $max_fortaleza = 0;
      $min_debilidad = 0;
      $max_debilidad = 0;
      $min_recomendacion = 0;
      $max_recomendacion = 0;
      
      if ($RegsIndicad) {
        //$regs_min = min($RegsIndicad) ?? 0;
        //$regs_max = max($RegsIndicad) ?? 0;
        foreach ($MinMaxIndicad as $key => $Indic) {
          if ('Fortaleza'==$Indic->valorativo) {
            $min_fortaleza = $Indic->min;
            $max_fortaleza = $Indic->max;
            $regs_min = $Indic->min; // revisar un poco mas
          }
          if ('Debilidad'==$Indic->valorativo) {
            $min_debilidad = $Indic->min;
            $max_debilidad = $Indic->max;
          }
          if ('Recomendación'==$Indic->valorativo) {
            $min_recomendacion = $Indic->min;
            $max_recomendacion = $Indic->max;
            $regs_max = $Indic->max; // revisar un poco mas
          }
        }
      }
      
      
      $this->fieldsToShow = $SegInt::getFieldsShow(show: 'calificar');
      $this->arrData = [
        'Periodo'           => $RegPeriodo,
        'Asignatura'        => $RegAsignatura,
        'Salon'             => $RegSalon,
        'Indicadores'       => $RegsIndicad,
        'annio_actual'      => (int)Config::get(var: 'config.academic.annio_actual'),
        'periodo_actual'    => (int)Config::get(var: 'config.academic.periodo_actual'),
        'min_fortaleza'     =>$min_fortaleza,
        'max_fortaleza'     =>$max_fortaleza,
        'min_debilidad'     =>$min_debilidad,
        'max_debilidad'     =>$max_debilidad,
        'min_recomendacion' =>$min_recomendacion,
        'max_recomendacion' =>$max_recomendacion,
        'min_indic' => $regs_min,
        'max_indic' => $regs_max,
        'cnt_indicador'   =>count(value: $RegsIndicad),
      ];
      View::select(view: 'notas/seguimientos/index');
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }//END-
  

  
  public function notasCalificarPlanesApoyo(int $periodo_id, int $salon_id, int $asignatura_id): void {
    try {
      $this->page_action = 'Calificar Planes de Apoyo del Sal&oacute;n';
      $RegSalon = (new Salon)->get($salon_id);
      $RegPeriodo =(new Periodo)->get($periodo_id);
      $RegAsignatura = (new Asignatura)->get($asignatura_id);

      $PA = new PlanesApoyo();
      $this->data = $PA->getBySalonAsignaturaPeriodos($salon_id, $asignatura_id, [$periodo_id]);
      $RegsIndicad = (new Indicador)->getIndicadoresCalificar($periodo_id, $RegSalon->grado_id, $asignatura_id);
      $MinMaxIndicad = (new Indicador)->getMinMaxByPeriodoGradoAsignatura($periodo_id, $RegSalon->grado_id, $asignatura_id);
      
      $regs_min = 0;
      $regs_max = 0;

      $min_fortaleza = 0;
      $max_fortaleza = 0;
      $min_debilidad = 0;
      $max_debilidad = 0;
      $min_recomendacion = 0;
      $max_recomendacion = 0;

      if ($RegsIndicad) {
        //$regs_min = min($RegsIndicad) ?? 0;
        //$regs_max = max($RegsIndicad) ?? 0;
        foreach ($MinMaxIndicad as $key => $Indic) {
          if ('Fortaleza'==$Indic->valorativo) {
            $min_fortaleza = $Indic->min;
            $max_fortaleza = $Indic->max;
            $regs_min = $Indic->min; // revisar un poco mas
          }
          if ('Debilidad'==$Indic->valorativo) {
            $min_debilidad = $Indic->min;
            $max_debilidad = $Indic->max;
          }
          if ('Recomendación'==$Indic->valorativo) {
            $min_recomendacion = $Indic->min;
            $max_recomendacion = $Indic->max;
            $regs_max = $Indic->max; // revisar un poco mas
          }
        }
      }
      
      $this->fieldsToShow = $PA::getFieldsShow(show: 'calificar');
      $this->arrData = [
        'Periodo'           => $RegPeriodo,
        'Asignatura'        => $RegAsignatura,
        'Salon'             => $RegSalon,
        'Indicadores'       => $RegsIndicad,
        'annio_actual'      => (int)Config::get(var: 'config.academic.annio_actual'),
        'periodo_actual'    => (int)Config::get(var: 'config.academic.periodo_actual'),
        'min_fortaleza'     =>$min_fortaleza,
        'max_fortaleza'     =>$max_fortaleza,
        'min_debilidad'     =>$min_debilidad,
        'max_debilidad'     =>$max_debilidad,
        'min_recomendacion' =>$min_recomendacion,
        'max_recomendacion' =>$max_recomendacion,
        'min_indic' => $regs_min,
        'max_indic' => $regs_max,
        'cnt_indicador'   =>count(value: $RegsIndicad),
      ];
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
    View::select(view: 'notas/planes_apoyo/index');
  }//END-
  
  public function perfilUsuario(): void {
    $this->page_action = 'Perfil del Usuario';
    //$this->data = (array)(new Usuario())::get($this->user_id);
    View::select(view: 'perfilUsuario/index');
  }//END-perfilUsuario




} // END CLASS
