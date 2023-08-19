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

        $user_id = (1!=$this->user_id) ? $this->user_id : 22482 ; // simular un usuario de padres
        $this->data = (new Estudiante)->getListPadres($user_id);
      
      } catch (\Throwable $th) {
        OdaFlash::error($th);
      }
      View::select('estudiantes/index');
    } //END-estudiantes
    
} // END CLASS
