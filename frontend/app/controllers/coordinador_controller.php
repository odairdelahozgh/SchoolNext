<?php
/**
  * Controlador Coordinacion  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class CoordinadorController extends AppController
{
    
    protected function before_filter() {
      // Si es AJAX enviar solo el view
      if (Input::isAjax()) {
          View::template(null);
      }
  }

    // ===============
    public function index() {
      $this->page_action = 'M&oacute;dulo Coordinaci&oacute;n';
    }
    
    // ===============
    public function gestion_registros() {
      $this->page_action = 'Gesti&oacute;n Registros';
      $this->annios = range((int)Config::get('config.academic.annio_actual'), 2021, -1);
      View::select('registros/index');
    }

    // ===============
    //public function consolidado_notas() {
    public function consolidado() {
      $this->page_action = 'Consolidado de Notas';
      $this->data = (new Salon())->getListActivos();
      View::select('consolidado/index');
    }

    // ===============
    public function notas_salon_json(int $salon_id) {
      View::template(null);
      //View::select(null);
      $notas = (new Nota())->getNotasSalon($salon_id);
      return json_encode($notas);
    }

    // ===============
    public function historico_notas() {
      $this->page_action = 'Hist&oacute;rico de Notas';
      $this->data = (new NotaHist() )->getTotalAnniosPeriodosSalones();
      View::select('historico_notas/index');
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
