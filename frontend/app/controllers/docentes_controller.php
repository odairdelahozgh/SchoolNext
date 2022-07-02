<?php
/**
  * Controlador Docentes  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class DocentesController extends AppController
{
  
  public function index() {
      $this->page_action = 'M&oacute;dulo Docentes';
  }
    
  //=============
  public function carga() {
    $this->page_action = 'Carga Acad&eacute;mica';
    $this->breadcrumb  = $this->bc('Carga');
    $this->data = (new CargaProfesor)->getCarga($this->user_id);
    $this->tot_regs = count($this->data);
  }

  //=============
  public function direccion_grupo() {
    $this->page_action = 'Direcci&oacute;n de Grupo';
    $this->breadcrumb  = $this->bc('Dirección');

    View::select('direccion_grupo/index');
  }

  //=============
  public function registros_gen() {
    $this->page_action = 'Mis Registros - Observaciones Generales';
    $this->breadcrumb  = $this->bc('Observaciones Generales');
    
    $this->resumen = (new RegistrosGen)->getRegistrosProfesorResumen(Session::get('id'));
    $this->data = (new RegistrosGen)->getRegistrosProfesor(Session::get('id'));
    $this->tot_regs = count($this->data);
    
    View::select('registros_gen/index');
  }
  
  public function indicadores($asignatura_id, $grado_id) {
    $this->page_action = 'Indicadores de Logro';
    $this->breadcrumb  = $this->bc('Carga;Indicadores');

    $this->asignatura = (new Asignatura)->get((int)$asignatura_id);
    $this->grado = (new Grado)->get((int)$grado_id);

    $indicadores = (new Indicador)->getIndicadores((int)$asignatura_id, (int)$grado_id);
    $arrIndic = array( 1=>array(), 2=>array(), 3=>array(), 4=>array(), 5=>array() );
    foreach ($indicadores as $key => $indic) {
      array_push($arrIndic[$indic->periodo_id], $indic);
    }
    $this->data = $arrIndic;
    View::select('indicadores/list');
  }
  
  public function notas($asignatura_id, $salon_id) {
    $this->page_action = 'Notas del Sal&oacute;n';
    $this->breadcrumb  = $this->bc('Carga;Notas');
    
    $this->Asignatura = (new Asignatura)->get((int)$asignatura_id);
    $this->Salon = (new Salon)->get((int)$salon_id);

    // limitar el numero de periodos
    $periodo_actual = (int)Config::get('academico.periodo_actual');
    $arr_periodos = range(1, $periodo_actual);
    $Notas = (new Nota)->getNotasSalonAsignaturaPeriodos((int)$salon_id,(int)$asignatura_id, $arr_periodos);
    
    $arrNotas = array( 1=>array(), 2=>array(), 3=>array(), 4=>array(), 5=>array() );

    foreach ($Notas as $key => $nota) {
      array_push($arrNotas[$nota->periodo_id], $nota);
    }
    $this->data = $arrNotas;
    View::select('notas/list');
  }

} // END CLASS
