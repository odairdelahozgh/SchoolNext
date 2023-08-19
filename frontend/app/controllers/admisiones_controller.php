<?php
/**
  * Controlador Admisiones
  * @category App
  * @package Controllers 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class AdmisionesController extends DmzController
{
  
  public function index() {
    try {
      $this->theme = 'dark';
      $this->themei = 'd';

      $this->page_action = 'Inicio';
      View::template('admisiones');
      //View::select('index', 'looper/component-steps');

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-index

  public function success($id) {
    try {
      $this->page_action = 'Success';
      View::template('admisiones');
      $this->data = (new Aspirante())::get($id);
      $GradosActivos = (new Grado())->getListActivos();
      $this->arrData['Grados'] = null;
      foreach ($GradosActivos as $key => $grado) {
        $this->arrData['Grados'][$grado->id] = $grado->nombre;
      }
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-success


} // END CLASS