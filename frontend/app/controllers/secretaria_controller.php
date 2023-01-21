<?php
/**
  * Controlador Secretaria  
  * @category App
  * @package Controllers 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class SecretariaController extends AppController
{    
    protected function before_filter() {
      $this->theme = Session::get('theme');
    }

    public function index() {
      $this->page_action = 'M&oacute;dulo Secretar&iacute;a';
    }
    
    public function listadoEstudActivos() {
      $this->page_action = 'Estudiantes Activos';
      $this->data = (new Estudiante)->getListActivos();
      //$this->theme = Session::get('theme');
      View::select('estudiantes/estud_list_activos');
    } // END-listadoEstudActivos
    
    public function listadoEstudInactivos() {
      $this->page_action = 'Estudiantes Inactivos';
      $this->data = (new Estudiante)->getListInactivos();
      $this->num_regs = Count($this->data);
      //$this->theme = Session::get('theme');
      View::select('estudiantes/estud_list_inactivos');
    } // END-listadoEstudInactivos
    
    public function actualizarPago($estudiante_id) {
      (new Estudiante)->setActualizarPago((int)$estudiante_id);
      Redirect::toAction('listadoEstudActivos');
    } // END-actualizarPago
    
    
    public function activarEstudiante($estudiante_id) {
      (new Estudiante)->setActivar((int)$estudiante_id);
      Redirect::toAction('listadoEstudInactivos');
    } // END-activarEstudiante
    

    /**
     * Editar un Registro de Estudiante
     * @param int $id (requerido)
     */
    public function editarEstudActivos(int $id) {
      $this->page_action = 'Editar un Registro de Estudiante';
      $obj_estudiante = new Estudiante;
      if (Input::hasPost('estudiante')) { // se verifica si se ha enviado el formulario (submit)
          if ($obj_estudiante->update(Input::post('estudiante'))) {
            OdaFlash::valid('Operaci&oacute;n exitosa [editar registro]');
              return Redirect::to(); // enrutando por defecto al index del controller
          }
          OdaFlash::error("Fall&oacute; Operaci&oacute;n [editar registro estudiante id=$id]", true);
          return;
      }
      // Aplicando la autocarga de objeto, para comenzar la edici&oacute;n
      $this->estudiante = $obj_estudiante->get((int)$id);
      View::select('estudiantes/estud_edit_activos');
    } // END-editarEstudActivos


  /**
   * Cambiar de salon a un estudiante
   * @param int $estudiante_id (requerido)
   * @param int $salon_id (requerido)
   * @param int $audit (requerido)
   */
  public function cambiar_salon_estudiante(int $estudiante_id, int $salon_id, bool $cambiar_en_notas = true) {
    $Estud = (new Estudiante)::first("SELECT * FROM sweb_estudiantes WHERE id=?", [(int)$estudiante_id]);
    if ( $Estud->setCambiarSalon((int)$salon_id, $cambiar_en_notas) ) {
      OdaFlash::valid("Operación exitosa [Cambiar salón] $Estud", true);
    } else {
      OdaFlash::error("Falló Operación [Cambiar salón]", true);
    }
    return Redirect::to('/secre-estud-list-activos');
  }


  /**
   * Index a Historico notas
   */
  public function historico_notas() {
    $this->page_action = 'Hist&oacute;rico de Notas';
    $this->data = (new NotaHist() )->getTotalAnniosPeriodosSalones();
    View::select('historico_notas/index');
  }


} // END CLASS
