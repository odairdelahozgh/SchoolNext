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
  public function cambiar_salon_estudiante(int $estudiante_id, int $salon_id, bool $cambiar_en_notas = true) {
    $Estud = (new Estudiante)::first("SELECT * FROM sweb_estudiantes WHERE id=?", [(int)$estudiante_id]);
    if ( $Estud->setCambiarSalon((int)$salon_id, $cambiar_en_notas) ) {
      OdaFlash::valid("Operaci&oacute;n exitosa [Cambiar sal&oacute;n a $Estud]", true);
    } else {
      OdaFlash::error("Fall&oacute; Operaci&oacute;n [Cambiar sal&oacute;n a $Estud]", true);
    }
    return Redirect::to('coordinador/index');//pendiente la redirección..
  }

  
} // END CLASS
