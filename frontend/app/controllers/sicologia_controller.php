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

    
    
} // END CLASS