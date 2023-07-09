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
      $this->page_action = 'M&oacute;dulo Secretar&iacute;a';
      $this->data = (new Evento)->getEventosDashboard();
    }
    
    public function listadoEstudActivos() {
      $this->page_action = 'Listado de Estudiantes Activos';
      $this->data = (new Estudiante)->getListSecretaria(estado:1);
      View::select('estudiantes/estud_list_activos');
    } // END-listadoEstudActivos
    
    public function listadoEstudInactivos() {
      $this->page_action = 'Listado de Estudiantes Inactivos';
      $this->data = (new Estudiante)->getListSecretaria(estado:0);
      View::select('estudiantes/estud_list_inactivos');
    } // END-listadoEstudInactivos
    
    
    /**
     * Actualizar Mes Pagado de un Estudiante
     */
    public function actualizarPago(int $estudiante_id) {
      $this->page_action = 'Actualizar Mes Pagado Estudiante';
      $Estud = (new Estudiante)->get($estudiante_id);
      if ($Estud->setActualizarPago($estudiante_id)) {
        OdaFlash::valid("$this->page_action: $Estud");
      } else {
        OdaFlash::warning("$this->page_action: $Estud");
      }
      Redirect::toAction('listadoEstudActivos');
    } // END-actualizarPago
    

    public function setMesPago(int $estudiante_id, int $mes) {
      $this->page_action = 'Actualizar Mes Pagado Estudiante';
      $Estud = (new Estudiante)->get($estudiante_id);
      if ($Estud->setMesPago(estudiante_id: $estudiante_id, mes: $mes)) {
        OdaFlash::valid("$this->page_action: $Estud");
      } else {
        OdaFlash::warning("$this->page_action: $Estud");
      }
      Redirect::toAction(action: 'listadoEstudActivos');
    } // END-setMesPago
    


    /**
     * Activar un Estudiante
     */
    public function activarEstudiante(int $estudiante_id) {
      $this->page_action = 'Activar Estudiante';
      $Estud = (new Estudiante)->get($estudiante_id);
      if ($Estud->setActivar()) {
        OdaFlash::valid("$this->page_action: $Estud");
      } else {
        OdaFlash::warning("$this->page_action: $Estud");
      }
      Redirect::toAction('listadoEstudInactivos');
    } // END-activarEstudiante
    

    /**
     * Editar un Registro de Estudiante: estudiantes/estud_edit_activos
     */
    public function editarEstudActivos(int $id) {
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
      View::select('estudiantes/estud_edit_activos');
    } // END-editarEstudActivos


  /**
   * Cambiar de salon a un estudiante: /secre-estud-list-activos
   */
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


  /**
   * Index a Historico notas: historico_notas/index
   */
  public function historico_notas() {
    $this->page_action = 'Hist&oacute;rico de Notas';
    $this->data = (new NotaHist() )->getTotalAnniosPeriodosSalones();
    View::select('historico_notas/index');
  }


} // END CLASS
