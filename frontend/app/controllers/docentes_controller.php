<?php
/**
  * Controlador Docentes  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class DocentesController extends AppController
{

  /**
   * Método Index
   */
  public function index() {
      $this->page_action = 'M&oacute;dulo Docentes';
  }//END-index
    

  /**
   * Método Carga
   */
  public function carga() {
    $this->page_action = 'Carga Acad&eacute;mica';
    $this->data = (new CargaProfesor)->getCarga($this->user_id);
    //$this->breadcrumb->addCrumb(key: 1, title:'Carga', url:Router::get('module') . '/' . Router::get('controller'));
    $this->tot_regs = count($this->data);
  }//END-carga

  /**
   * Método Dirección de Grupo
   */
  public function direccion_grupo() {
    $this->page_action = 'Direcci&oacute;n de Grupo';
    //$this->breadcrumb->addCrumb(title:'Dirección', url:'');

    View::select('direccion_grupo/index');
  }//END-direccion_grupo

  /**
   * registros_observaciones/list
   */
  public function registros_observaciones() {
    $this->page_action = 'Registros de Observaciones';
    //$this->breadcrumb->addCrumb(title:'Observaciones Generales', url:'');
    
    $this->resumen = (new RegistrosGen)->getRegistrosProfesorResumen(Session::get('id'));
    $this->data = (new RegistrosGen)->getRegistrosProfesor(Session::get('id'));
    $this->tot_regs = count($this->data);
    
    View::select('registros_observaciones/list');
  }//END-registros_observaciones
  
  /**
   * indicadores/list
   */
  public function indicadores(int $asignatura_id, int $grado_id) {
    $this->page_action = 'Indicadores de Logro';
    //$this->breadcrumb->addCrumb(title:'Carga', url:'docentes/carga');

    $this->RegAsignatura = (new Asignatura)->get($asignatura_id);
    $this->RegGrado = (new Grado)->get($grado_id);

    $indicadores = (new Indicador)->getIndicadores($asignatura_id, $grado_id);
    $arrIndic = array( 1=>array(), 2=>array(), 3=>array(), 4=>array(), 5=>array() );
    foreach ($indicadores as $indic) {
      array_push($arrIndic[$indic->periodo_id], $indic);
    }
    $this->data = $arrIndic;
    View::select('indicadores/list');
  }//END-indicadores

  /**
   * notas/list
   */
  public function notas(int $asignatura_id, int $salon_id) {
    $this->page_action = 'Notas del Sal&oacute;n';
    //$this->breadcrumb->addCrumb(key:1, title:'Carga', url:'docentes/carga');
    
    $this->Asignatura = (new Asignatura)->get($asignatura_id);
    $this->Salon = (new Salon)->get($salon_id);

    // limitar el numero de periodos
    $periodo_actual = (int)Config::get('config.academic.periodo_actual');
    $arr_periodos = range(1, $periodo_actual);
    $Notas = (new Nota)->getNotasSalonAsignaturaPeriodos($salon_id, $asignatura_id, $arr_periodos);
    
    $arrNotas = array( 1=>array(), 2=>array(), 3=>array(), 4=>array(), 5=>array() );

    foreach ($Notas as $key => $nota) {
      array_push($arrNotas[$nota->periodo_id], $nota);
    }
    $this->data = $arrNotas;
    View::select('notas/list');
  }//END-notas



} // END CLASS
