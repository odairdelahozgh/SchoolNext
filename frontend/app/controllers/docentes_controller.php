<?php
/**
  * Controlador  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */

class DocentesController extends AppController
{


  protected function before_filter() 
  {
    parent::before_filter();

    if (!str_contains('docentes', Session::get('roll')) 
      && !str_contains('admin', Session::get('roll')) 
      && !str_contains('coordinadores', Session::get('roll')) )
    {
      OdaFlash::warning('No tiene permiso de acceso al módulo DOCENTES, fué redirigido');
      Redirect::to(Session::get('modulo'));
    }
  }


  public function seguimientos_grupo() 
  {
    try 
    {
      $this->page_action = 'Seguimientos del Grupo';
      $this->data = (new usuario)->misGrupos();
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select('direccionDeGrupo/seguimientos_consolidado');
  }


  public function registros_grupo() 
  {
    try 
    {
      $this->page_action = 'Registros del Grupo';
      $this->data = (new usuario)->misGrupos();
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select('direccionDeGrupo/dg_registros_consoli');
  }  


  public function index() 
  {
    try 
    {
      $this->page_action = 'Inicio';
      $this->data = (new Evento)->getEventosDashboard();
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
  }


  public function carga(): void 
  {
    try 
    {
      $this->page_action = 'Carga Acad&eacute;mica';
      $this->data = (new SalAsigProf)->getCarga($this->user_id);
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
  }

  
  public function asignar_carga(): void 
  {
    try 
    {
      $this->page_action = 'Asignar Carga Acad&eacute;mica';
      $usuario = $this->user_id;
      if (1==$usuario)  // admin
      {
        $sap = (new SalAsigProf)::first(
          "SELECT sap.user_id as ultimo_user_id FROM ".Config::get('tablas.salon_asignat_profe')." AS sap WHERE sap.id =(SELECT MAX(sapm.id) as max  FROM ".Config::get('tablas.salon_asignat_profe')." AS sapm)"
        );
        $usuario = $sap->ultimo_user_id;
      }
      $this->data = (new SalAsigProf)->getCarga($this->user_id); // siempre la carga del usuario logeado
      $this->arrData[0] = $usuario;
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }

  
  public function direccion_grupo(): void 
  {
    try 
    {
      $this->page_action = 'Direcci&oacute;n de Grupo';
      $periodo = Session::get('periodo');
      $this->data = (new usuario)->misGrupos();
      for ($i=1; $i <=$periodo ; $i++) 
      { 
        $a_regs = (new Nota)::getNotasPromAnnioPeriodoSalon($i, $this->data[0]->id);
        foreach ($a_regs as $key => $value) 
        {
          $this->arrData[$value->asignatura_nombre][$i]['avg'] = $value->avg;
        }
      }
      $this->buttons = [];
      foreach ($this->data as $key => $salon) 
      {
        $this->buttons[$key] = ['caption'=>$salon, 'action'=>"traer_data($salon->id)"];
      }  
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select('direccionDeGrupo/index');
  }


  public function registros_observaciones(): void 
  {
    try 
    {
      $this->page_action = 'Registros de Observaciones Generales';
      //[31	dianarc] [33	jackelinerr] [19	lizbethgc]
      $es_coordinador =  [31, 33, 19];
      if ( in_array($this->user_id, $es_coordinador) ) 
      {
        $estudiantes = (new Estudiante)->getListEstudiantes(estado: 1);
      } 
      else 
      {
        $estudiantes = (new Estudiante)->getListPorProfesor($this->user_id);
      }
      $this->arrData = ['estudiantes' => $estudiantes];
      $this->data = (new RegistrosGen)->getRegistrosProfesor($this->user_id);
    } 
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
    View::select('registrosObservGenerales/index');
  }
  
  
  public function registros_desemp_acad(): void 
  {
    try 
    {
      $this->page_action = 'Registros de Desempeño Académico';
      //$estudiantes = (new Estudiante)->getListEstudiantes(estado: 1);
      $estudiantes = (new Estudiante)->getListPorDirector($this->user_id);
      $this->arrData = ['estudiantes' => $estudiantes];
      $this->data = (new RegistroDesempAcad)->getRegistrosProfesor(user_id: Session::get('id'));
    }
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select('registrosDesempAcad/index');
  }


  public function listIndicadores(
    int $grado_id, 
    int $asignatura_id): void 
  {
    try 
    {
      $this->page_action = 'Indicadores de Logro';
      //$RegGrado = (new Grado)->get($grado_id);
      //$RegAsignatura = (new Asignatura)->get($asignatura_id);
      $this->arrData = [
        'grado' => (new Grado)->get($grado_id), 
        'asignatura' => (new Asignatura)->get($asignatura_id) 
      ];
    }
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select(view: 'indicadores/index');
  }


  public function listNotas(
    int $asignatura_id, 
    int $salon_id): void 
  {
    try 
    { 
      $this->page_action = 'Notas del Sal&oacute;n';
      $RegAsignatura = (new Asignatura)::get($asignatura_id);
      $RegSalon = (new Salon)::get($salon_id);
      $max_periodo = ($this->_periodo_actual>=4) ? 5 : $this->_periodo_actual;
      for ($i=1; $i<=$max_periodo; $i++) 
      {
        $RegsIndicadP = (new Indicador)->getIndicadoresCalificar($i, $RegSalon->grado_id, $asignatura_id);
        $IndicP = [];
        foreach ($RegsIndicadP as $key => $object) 
        {
          $IndicP[$object->codigo] = get_object_vars($object);
        }
        $this->arrData["IndicadoresP{$i}"] = $IndicP;
      }
      $this->arrData['Asignatura'] = $RegAsignatura;
      $this->arrData['Salon'] = $RegSalon;
      $this->arrData['annio_actual'] = $this->_annio_actual;
      $this->arrData['periodo_actual'] = $this->_periodo_actual;
      $Notas = (new Nota)->getBySalonAsignaturaPeriodos(
        $salon_id, 
        $asignatura_id, 
        range(1, $max_periodo) 
      );
      if (0 == count($Notas)) 
      {
        OdaFlash::info('No hay registros para mostrar.');
      }      
      $this->data = array( 5=>[], 4=>[], 3=>[], 2=>[], 1=>[] );
      foreach ($Notas as $key => $nota) 
      {
        array_push($this->data[$nota->periodo_id], $nota);
      }
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th, true);
    }
    View::select('notas/list');
  }


  public function notasCalificar(int $periodo_id, int $salon_id, int $asignatura_id): void {
    try 
    {
      $this->page_action = 'Calificar Notas del Sal&oacute;n';
      $RegSalon = (new Salon)->get($salon_id);
      $RegPeriodo =(new Periodo)->get($periodo_id);
      $RegAsignatura = (new Asignatura)->get($asignatura_id);
      $this->data = (new Nota)->getBySalonAsignaturaPeriodos(salon_id: $salon_id, asignatura_id: $asignatura_id, periodos: [$periodo_id]);
      $RegsIndicad = (new Indicador)->getIndicadoresCalificar($periodo_id, $RegSalon->grado_id, $asignatura_id);
      $MinMaxIndicad = (new Indicador)->getMinMaxByPeriodoGradoAsignatura($periodo_id, $RegSalon->grado_id, $asignatura_id);
      $RegsIndicadP = (new Indicador)->getIndicadoresCalificar($periodo_id, $RegSalon->grado_id, $asignatura_id);
      $IndicP = [];
      foreach ($RegsIndicadP as $key => $object) 
      {
        $IndicP[$object->codigo] = get_object_vars($object);
      }
      $this->arrData = [
        'Periodo'           => $RegPeriodo,
        'Asignatura'        => $RegAsignatura,
        'Salon'             => $RegSalon,
        'Indicadores'       => $RegsIndicad,
        'IndicRef'          => $IndicP,
        'annio_actual'      => $this->_annio_actual,
        'periodo_actual'    => $this->_periodo_actual,
        'min_fortaleza'     => $MinMaxIndicad['min_fortaleza'],
        'max_fortaleza'     => $MinMaxIndicad['max_fortaleza'],
        'min_debilidad'     => $MinMaxIndicad['min_debilidad'],
        'max_debilidad'     => $MinMaxIndicad['max_debilidad'],
        'min_recomendacion' => $MinMaxIndicad['min_recomendacion'],
        'max_recomendacion' => $MinMaxIndicad['max_recomendacion'],
        'min_indic'         => $MinMaxIndicad['regs_min'],
        'max_indic'         => $MinMaxIndicad['regs_max'],
        'ancho_lim'         => $MinMaxIndicad['ancho_lim'],
        //'cnt_indicador'     => count($RegsIndicad),
      ];
    }
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select(view: 'notas/calificar/index');
  }


  public function notasCalificarSeguimientos(
    int $periodo_id, 
    int $salon_id, 
    int $asignatura_id): void 
  {
    try 
    {
      $this->page_action = 'Seguimientos Intermedios del Sal&oacute;n';
      $RegSalon = (new Salon)->get($salon_id);
      $RegPeriodo =(new Periodo)->get($periodo_id);
      $RegAsignatura = (new Asignatura)->get($asignatura_id);
      $this->data = (new Seguimientos)->getBySalonAsignaturaPeriodos($salon_id, $asignatura_id, [$periodo_id]);
      $RegsIndicad = (new Indicador)->getIndicadoresCalificar(periodo_id: $periodo_id, grado_id: $RegSalon->grado_id, asignatura_id: $asignatura_id);
      $MinMaxIndicad = (new Indicador)->getMinMaxByPeriodoGradoAsignatura($periodo_id, $RegSalon->grado_id, $asignatura_id);
      
      $this->arrData = [
        'Periodo'           => $RegPeriodo,
        'Asignatura'        => $RegAsignatura,
        'Salon'             => $RegSalon,
        'Indicadores'       => $RegsIndicad,
        'annio_actual'      => $this->_annio_actual,
        'periodo_actual'    => $this->_periodo_actual,
        'min_fortaleza'     => $MinMaxIndicad['min_fortaleza'],
        'max_fortaleza'     => $MinMaxIndicad['max_fortaleza'],
        'min_debilidad'     => $MinMaxIndicad['min_debilidad'],
        'max_debilidad'     => $MinMaxIndicad['max_debilidad'],
        'min_recomendacion' => $MinMaxIndicad['min_recomendacion'],
        'max_recomendacion' => $MinMaxIndicad['max_recomendacion'],
        'min_indic'         => $MinMaxIndicad['regs_min'],
        'max_indic'         => $MinMaxIndicad['regs_max'],
        'ancho_lim'         => $MinMaxIndicad['ancho_lim'],
        'cnt_indicador'     => count($RegsIndicad),
      ];
      View::select(view: 'notas/seguimientos/index');
    }
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
  }

  
  public function notasCalificarPlanesApoyo(
    int $periodo_id, 
    int $salon_id, 
    int $asignatura_id): void 
  {
    try 
    {
      $this->page_action = 'Calificar Planes de Apoyo del Sal&oacute;n';
      $RegSalon = (new Salon)->get($salon_id);
      $RegPeriodo =(new Periodo)->get($periodo_id);
      $RegAsignatura = (new Asignatura)->get($asignatura_id);
      $this->data = (new PlanesApoyo)->getBySalonAsignaturaPeriodos($salon_id, $asignatura_id, [$periodo_id]);
      $RegsIndicad = (new Indicador)->getIndicadoresCalificar($periodo_id, $RegSalon->grado_id, $asignatura_id);
      $MinMaxIndicad = (new Indicador)->getMinMaxByPeriodoGradoAsignatura($periodo_id, $RegSalon->grado_id, $asignatura_id);
      $this->arrData = [
        'Periodo'           => $RegPeriodo,
        'Asignatura'        => $RegAsignatura,
        'Salon'             => $RegSalon,
        'Indicadores'       => $RegsIndicad,
        'annio_actual'      => $this->_annio_actual,
        'periodo_actual'    => $this->_periodo_actual,
        'min_fortaleza'     => $MinMaxIndicad['min_fortaleza'],
        'max_fortaleza'     => $MinMaxIndicad['max_fortaleza'],
        'min_debilidad'     => $MinMaxIndicad['min_debilidad'],
        'max_debilidad'     => $MinMaxIndicad['max_debilidad'],
        'min_recomendacion' => $MinMaxIndicad['min_recomendacion'],
        'max_recomendacion' => $MinMaxIndicad['max_recomendacion'],
        'min_indic'         => $MinMaxIndicad['regs_min'],
        'max_indic'         => $MinMaxIndicad['regs_max'],
        'ancho_lim'         => $MinMaxIndicad['ancho_lim'],
        'cnt_indicador'     => count($RegsIndicad),
      ];
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select(view: 'notas/planes_apoyo/index');
  }
  

  public function perfilUsuario(): void 
  {
    $this->page_action = 'Perfil del Usuario';
    //$this->data = (array)(new Usuario())::get($this->user_id);
    View::select(view: 'perfilUsuario/index');
  }



}