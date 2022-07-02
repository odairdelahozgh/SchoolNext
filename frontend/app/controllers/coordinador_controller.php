<?php
/**
  * Controlador Coordinacion  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class CoordinadorController extends AppController
{
    //public $theme="w3-theme-purple";
    
    // ===============
    protected function before_filter() {
    }

    // ===============
    public function index() {
      $this->page_action = 'M&oacute;dulo Coordinaci&oacute;n';
    }
    
    // ===============
    public function gestion_registros() {
      $this->page_action = 'Gesti&oacute;n Registros';
    }

    // ===============
    public function consolidado_notas() {
      $this->page_action = 'Consolidado Notas';
    }
    
    
  // ==============================
  // MÉTODOS ADICIONALES
  // ==============================
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
    return Redirect::to('coordinador/????');//pendiente la redirección..
  }

  
} // END CLASS
