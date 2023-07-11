<?php
/**
  * Controlador Padres  
  * @category App
  * @package Controllers 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class PadresController extends AppController
{
    public function index(): void {
      $this->page_action = 'Inicio';
    } //END-index
    
    
    public function contabilidad(): void {
      $this->page_action = 'Información Contable';
    } //END-contabilidad
    
    public function estudiantes(): void {
      try {
        $this->page_action = 'Estudiantes a Cargo';
        $this->arrData['periodo'] = Session::get('periodo');
        $this->data = (new Estudiante)->getListPadres($this->user_id);
      
      } catch (\Throwable $th) {
        OdaFlash::error($th);
      }
      View::select('estudiantes/index');
    } //END-estudiantes
    
} // END CLASS
