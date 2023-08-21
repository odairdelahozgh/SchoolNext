<?php
/**
  * Controlador Coordinacion  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class CoordinadorController extends AppController
{
  
  protected function before_filter() {
    // Si es AJAX enviar solo el view
    if (Input::isAjax()) {
      View::template(null);
    }
  } //END-before_filter


  public function index() {
    $this->page_action = 'M&oacute;dulo Coordinaci&oacute;n';
  } //END-index
  

  public function listadoEstudiantes() {
    try {
      $this->page_action = 'Listado de Estudiantes Activos';
      $this->data = (new Estudiante)->getListSecretaria(estado:1);
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
    View::select('estudiantes/index');
  } // END-listadoEstudiantes


  public function gestion_registros() {
    $this->page_action = 'Gesti&oacute;n Registros';
    $this->annios = range((int)Config::get('config.academic.annio_actual'), 2021, -1);
    View::select('registros/index');
  } //END-gestion_registros

  
  public function consolidado() {
    try {
      $this->page_action = 'Consolidado de Notas';
      $this->data = (new Salon())->getByCoordinador(Session::get('id'));
    
    } catch (\Throwable $th) {
    OdaFlash::error($th);
    }
    View::select('consolidado/index');
  } //END-consolidado_notas

  
  public function seguimientosConsolidado() {
    try {
      $this->page_action = 'Consolidado de Notas';
      $this->data = (new Seguimientos())::getConsolidadoBySalonPeriodo('fde6d4554a101204ca5c', 3);
    
    } catch (\Throwable $th) {
    OdaFlash::error($th);
    }
    View::select('segumientos/consolidado');
  } //END-consolidado_notas
  

  public function notas_salon_json(int $salon_id) {
    View::template(null);
    //View::select(null);
    $notas = (new Nota())->getNotasSalon($salon_id);
    return json_encode($notas);
  } //END-notas_salon_json

  
  public function historico_notas() { // Al index de Historico notas
    try {
      $this->page_action = 'Hist&oacute;rico de Notas';
      //$this->data = range(Config::get('config.academic.annio_actual')-1, Config::get('config.academic.annio_inicial'), -1);
      $this->data = range(Config::get('config.academic.annio_actual')-1, 2010, -1);
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
    View::select('historico_notas/index');
    } //END-historico_notas


  public function cambiar_salon_estudiante(int $estudiante_id, int $salon_id, bool $cambiar_en_notas = true) {
    $this->page_action = 'Cambiar de Salón a Estudiante';
    $Estud = (new Estudiante)::first("SELECT * FROM sweb_estudiantes WHERE id=?", [$estudiante_id]);
    
    if ( $Estud->setCambiarSalon((int)$salon_id, $cambiar_en_notas) ) {
      OdaFlash::valid("$this->page_action: $Estud]");
    } else {
      OdaFlash::warning("$this->page_action: $Estud]");
    }
    return Redirect::to('coordinador/index');//pendiente la redirección..
  } //END-cambiar_salon_estudiante

  

  public function admisiones() {
    try {
      $this->page_action = 'M&oacute;dulo de Admisiones';
      $select = implode(', ', (new Aspirante)::getFieldsShow(show: 'index', prefix: 't.'));
      $this->data = (new Aspirante)->getListActivos(select: $select);

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }

    View::select('admisiones/index');
  } //END-admisiones


} // END CLASS