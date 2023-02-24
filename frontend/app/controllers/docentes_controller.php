<?php
/**
  * Controlador Docentes  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */

require_once APP_PATH . '../vendor/autoload.php';
use Mpdf\Mpdf;

class DocentesController extends AppController
{

  public function example1() {
    //Importante: Sin vista y sin tamplate 
    View::select(null, null);
    //Crea una instancia de la clase y le pasa el directorio default/app/temp/ 
    $mpdf = new Mpdf(['tempDir' => APP_PATH . '/temp']);
    //Escribe algo de contenido HTML: 
    $mpdf->WriteHTML('¡Hola KumbiaPHP!');
    //Envía un archivo PDF directamente al navegador 
    $mpdf->Output(); 
  }

  /**
   * Método Index
   */
  public function index() {
      $this->page_action = 'M&oacute;dulo Docentes';
  }//END-index
    

  /**
   * $data: Carga Académica de Profesor
   */
  public function carga() {
    $this->page_action = 'Carga Acad&eacute;mica';
    $this->data = (new SalAsigProf)->getCarga($this->user_id);
  }//END-carga

  
  /**
   * $data: ASIGNAR Carga Académica de Profesor
   */
  public function asignar_carga() {
    $this->page_action = 'Asignar Carga Acad&eacute;mica';
    $usuario = $this->user_id;

    if (1==$usuario) { // admin
      $sap = (new SalAsigProf)::first("SELECT sap.user_id as ultimo_user_id FROM ".Config::get('tablas.salon_asignat_profe')." AS sap WHERE sap.id =(SELECT MAX(sapm.id) as max  FROM ".Config::get('tablas.salon_asignat_profe')." AS sapm)");
      $usuario = $sap->ultimo_user_id;
    }
    $this->data = (new SalAsigProf)->getCarga($this->user_id); // siempre la carga del usuario logeado
    $this->arrData[0] = $usuario;
  }//END-carga


  /**
   * Método Dirección de Grupo|
   */
  public function direccion_grupo() {
    $this->page_action = 'Direcci&oacute;n de Grupo';
    View::select('direccion_grupo/index');
  }//END-direccion_grupo

  /**
   * registros_observaciones/list
   */
  public function registros_observaciones() {
    $this->page_action = 'Registros de Observaciones Generales';
    $estudiantes = (new Estudiante)->getListEstudiantes(estado: 1);
    $this->arrData = ['estudiantes' => $estudiantes];
    $this->data = (new RegistrosGen)->getRegistrosProfesor(Session::get('id'));
    View::select('registrosObservGenerales/index');
  }//END-registros_observaciones
  /**
   * registros_desemp_acad
   */
  public function registros_desemp_acad() {
    $this->page_action = 'Registros de Desempeño Académico';
    $estudiantes = (new Estudiante)->getListEstudiantes(estado: 1);
    $this->arrData = ['estudiantes' => $estudiantes];
    $this->data = (new RegistroDesempAcad)->getRegistrosProfesor(Session::get('id'));
    View::select('registrosDesempAcad/index');
  }//END-registros_observaciones


  /**
   * indicadores/list
   */
  public function listIndicadores(int $grado_id, int $asignatura_id) {
    $this->page_action = 'Indicadores de Logro';

    $RegGrado = (new Grado)->get($grado_id);
    $RegAsignatura = (new Asignatura)->get($asignatura_id);
    $this->arrData = ['grado' => $RegGrado, 'asignatura' => $RegAsignatura];

    /* 
    $indicadores = (new Indicador)->getListIndicadores($asignatura_id, $grado_id);
    $arrIndic = array( 1=>array(), 2=>array(), 3=>array(), 4=>array(), 5=>array() );
    foreach ($indicadores as $indic) {
      array_push($arrIndic[$indic->periodo_id], $indic);
    }
    $this->data = $arrIndic; 
    */
    View::select('indicadores/list');
  }//END-indicadores


  /**
   * notas/list
   */
  public function listNotas(int $asignatura_id, int $salon_id) {
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


  /**
   * notas/notasCalificar
   */
  public function notasCalificar(int $periodo, int $salon_id, int $asignatura_id) {
    $this->page_action = 'Calificar Notas del Sal&oacute;n';

    $this->Asignatura = (new Asignatura)->get($asignatura_id);
    $this->Salon = (new Salon)->get($salon_id);
    
    $annio_actual   = (int)Config::get('config.academic.annio_actual');
    $periodo_actual = (int)Config::get('config.academic.periodo_actual');
    
    $this->arrData = [
      'annio_actual'   => $annio_actual,
      'periodo_actual' => $periodo_actual,
    ];

    $this->data = (new Nota)->getNotasSalonAsignaturaPeriodos($salon_id, $asignatura_id, [$periodo_actual]);
    View::select('notas/calificar/index');
  }//END-notas



} // END CLASS
