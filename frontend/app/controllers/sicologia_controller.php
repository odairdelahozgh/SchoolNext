<?php
/**
  * Controlador Secretaria  
  * @category App
  * @package Controllers 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class SicologiaController extends AppController
{
    
    public function index() {
      $this->page_action = 'Inicio';
      $this->data = (new Evento)->getEventosDashboard();
    }
    
    public function estudiantes() {
      $this->page_action = 'Estudiantes Activos';
      try {
        $this->data = (new Estudiante)->getListSicologia();
      
      } catch (\Throwable $th) {
        OdaFlash::error($th);
      }
      View::select('estudiantes/index');
    } //END-estudiantes
    


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

    
    public function admisiones_edit(int $aspirante_id) {
      try {
        $this->page_action = 'Admisiones - Editando Aspirante';
        $this->data = [0];
        $this->arrData['Aspirante'] = (new Aspirante)->get($aspirante_id);
        $this->arrData['AspirantePsico'] = (new AspirantePsico)::first('SELECT * FROM sweb_aspirantepsico WHERE aspirante_id=?', [$aspirante_id]);
      
      } catch (\Throwable $th) {
        OdaFlash::error($th);
      }

      View::select('admisiones/edit/edit');
    } //END-admisiones_edit
    

} // END CLASS