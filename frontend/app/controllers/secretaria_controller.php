<?php
/**
  * Controlador Secretaria  
  * @category App
  * @package Controllers 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class SecretariaController extends AppController
{  

  public function index() {
  $this->page_action = 'Inicio';
  try {
    $this->data = (new Evento)->getEventosDashboard();
  
  } catch (\Throwable $th) {
    OdaFlash::error($th);
  }
  } //END-index
  
  public function listadoEstudActivos() {
  try {
    $this->page_action = 'Listado de Estudiantes Activos';
    $this->data = (new Estudiante)->getListSecretaria(estado:1);
    $this->arrData['Salones'] = (array)(new Salon)->getList(estado:1);
  
  } catch (\Throwable $th) {
    OdaFlash::error($th);
  }
  View::select('estudiantes/estud_list_activos');
  } // END-listadoEstudActivos
  
  public function listadoEstudInactivos() {
  try {
    $this->page_action = 'Listado de Estudiantes Inactivos';
    $this->data = (new Estudiante)->getListSecretaria(estado:0);
  
  } catch (\Throwable $th) {
    OdaFlash::error($th);
  }
  View::select('estudiantes/estud_list_inactivos');
  } // END-listadoEstudInactivos
  
  
  public function actualizarPago(int $estudiante_id) { // Actualizar Mes Pagado de un Estudiante
  try {
    $this->page_action = 'Actualizar Mes Pagado Estudiante';
    $Estud = (new Estudiante)->get($estudiante_id);
    if ($Estud->setActualizarPago($estudiante_id)) {
    OdaFlash::valid("$this->page_action: $Estud");
    } else {
    OdaFlash::warning("$this->page_action: $Estud");
    }
  
  } catch (\Throwable $th) {
    OdaFlash::error($th);
  }
  Redirect::toAction('listadoEstudActivos');
  } // END-actualizarPago
  

  public function setMesPago(int $estudiante_id, int $mes) {
  try {
    $this->page_action = 'Actualizar Mes Pagado Estudiante';
    $Estud = (new Estudiante)->get($estudiante_id);
    if ($Estud->setMesPago(estudiante_id: $estudiante_id, mes: $mes)) {
    OdaFlash::valid("$this->page_action: $Estud");
    } else {
    OdaFlash::warning("$this->page_action: $Estud");
    }
  
  } catch (\Throwable $th) {
    OdaFlash::error($th);
  }
  Redirect::toAction(action: 'listadoEstudActivos');
  } // END-setMesPago
  


  /**
   * Activar un Estudiante
   */
  public function activarEstudiante(int $estudiante_id) {
  try {
    $this->page_action = 'Activar Estudiante';
    $Estud = (new Estudiante)->get($estudiante_id);
    if ($Estud->setActivar()) {
    OdaFlash::valid("$this->page_action: $Estud");
    } else {
    OdaFlash::warning("$this->page_action: $Estud");
    }
  
  } catch (\Throwable $th) {
    OdaFlash::error($th);
  }
  Redirect::toAction('listadoEstudInactivos');
  } // END-activarEstudiante
  

  /**
   * Editar un Registro de Estudiante: estudiantes/estud_edit_activos
   */
  public function editarEstudActivos(int $id) {
  try {
    $this->page_action = 'Editar Registro de Estudiante';
    $obj_estudiante = new Estudiante;
    if (Input::hasPost('estudiante')) { // se verifica si se ha enviado el formulario (submit)
    if ($obj_estudiante->update(Input::post('estudiante'))) {
      OdaFlash::valid("$this->page_action: $obj_estudiante");
      return Redirect::to(); // enrutando por defecto al index del controller
    }
    OdaFlash::warning("$this->page_action: $obj_estudiante");
    return;
    }
    // Aplicando la autocarga de objeto, para comenzar la edici&oacute;n
    $this->estudiante = $obj_estudiante->get($id);
  
  } catch (\Throwable $th) {
    OdaFlash::error($th);
  }
  View::select('estudiantes/estud_edit_activos');
  } // END-editarEstudActivos


  public function cambiar_salon_estudiante(int $estudiante_id, int $nuevo_salon_id, bool $cambiar_en_notas = true) {
    try {
      $this->page_action = 'Cambiar Sal&oacute;n Estudiante';
      $Estud = (new Estudiante)->get($estudiante_id);
      if ($Estud->setCambiarSalon($estudiante_id, $nuevo_salon_id, $cambiar_en_notas) ) {
        OdaFlash::valid("$this->page_action: $Estud");
      } else {
        OdaFlash::warning("$this->page_action: $Estud");
      }

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
    return Redirect::to('/secre-estud-list-activos');
  } // END-cambiar_salon_estudiante

  
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


} // END CLASS
