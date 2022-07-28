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
    }
    
    public function listadoEstudActivos() {
      $this->page_action = 'Estudiantes Activos';
      $this->data = (new Estudiante)->getList(1);
      $this->num_regs = Count($this->data);
      View::select('estudiantes/estud_list_activos');
    } // END-estud_list_activos
    
    public function listadoEstudInactivos() {
      $this->page_action = 'Estudiantes Inactivos';
      $this->data = (new Estudiante)->getList(0);
      $this->num_regs = Count($this->data);
      View::select('estudiantes/estud_list_inactivos');
    } // END-estud_list_inactivos
    
    public function actualizarPago($estudiante_id) {
      (new Estudiante)->setActualizarPago((int)$estudiante_id);
      Redirect::toAction('estud_list_activos');
    } // END-actualizarPago
    
    
    public function activarEstudiante($estudiante_id) {
      (new Estudiante)->setActivar((int)$estudiante_id);
      Redirect::toAction('/listadoEstudInactivos');
    } // END-activarEstud
    

    /**
     * Editar un Registro de Estudiante
     * @param int $id (requerido)
     */
    public function editarEstudActivos($id) {
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
    } // END-estud_edit_activos


  /**
   * Cambiar de salón a un estudiante
   * @param int $id (requerido)
   * @param int $salon_id (requerido)
   */
  public function cambiar_salon_estudiante($estudiante_id, $salon_id, $audit = true) {
    $Estud = (new Estudiante)::first("SELECT * FROM sweb_estudiantes WHERE id=?", [(int)$estudiante_id]);
    if ( $Estud->setCambiarSalon((int)$salon_id, $cambiar_notas=true) ) {
      OdaFlash::valid("Operaci&oacute;n exitosa [Cambiar sal&oacute;n]", $audit);
    } else {
      OdaFlash::error("Fall&oacute; Operaci&oacute;n [Cambiar sal&oacute;n]", true);
    }
    return Redirect::to('/secre-estud-list-activos');
  }

} // END CLASS
