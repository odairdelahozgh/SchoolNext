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
    
    public function estud_list_activos() {
      $this->page_action = 'Estudiantes Activos';
      $this->data = (new Estudiante)->getList(1);
      View::select('estudiantes/estud_list_activos');
    } // END-estud_list_activos
    
    public function estud_list_inactivos() {
      $this->page_action = 'Estudiantes Inactivos';
      $this->data = (new Estudiante)->getList(0);
      View::select('estudiantes/estud_list_inactivos');
    } // END-estud_list_inactivos
    
    public function actualizarPago($estudiante_id) {
      (new Estudiante)->setActualizarPago((int)$estudiante_id);
      Redirect::toAction('estud_list_activos');
    } // END-actualizarPago
    
    
    /**
     * Editar un Registro de Estudiante
     * @param int $id (requerido)
     */
    public function estud_edit_activos($id) {
      $this->page_action = 'Editar un Registro de Estudiante';
      $obj_estudiante = new Estudiante;
      if (Input::hasPost('estudiante')) { // se verifica si se ha enviado el formulario (submit)
          if ($obj_estudiante->update(Input::post('estudiante'))) {
            OdaFlash::valid('Operaci&oacute;n exitosa [editar registro]');
              return Redirect::to(); // enrutando por defecto al index del controller
          }
          OdaFlash::error("Fall&oacute; Operaci&oacute;n [editar registro estudiante id=$id]", __CLASS__);
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
    $estud = (new Estudiante)->get((int)$estudiante_id);
    $cambiar_notas = true;
    if ( $estud->setCambiarSalon((int)$salon_id, $cambiar_notas) ) {
      OdaFlash::valid("Operaci&oacute;n exitosa [Cambiar sal&oacute;n a $estud]", $audit);
    } else {
      OdaFlash::error("Fall&oacute; Operaci&oacute;n [Cambiar sal&oacute;n a $estud]", $audit);
    }
    return Redirect::to('secretaria/estud_list_activos');
  }

} // END CLASS
