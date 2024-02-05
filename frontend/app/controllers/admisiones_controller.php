<?php
/**
  * Controlador Admisiones
  * @category App
  * @package Controllers 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class AdmisionesController extends DmzController
{
  protected function before_filter()
  {
    parent::before_filter();

    $this->theme = 'dark';
    $this->themei = 'd';
    View::template('admisiones');
  }


  public function index() 
  {
    try
    {
      $this->page_action = 'Inicio';
      //View::select('index', 'looper/component-steps');
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }


  public function success($id) 
  {
    try
    {
      $this->page_action = 'Success';
      $this->data = (new Aspirante())::get($id);
      $GradosActivos = (new Grado())->getListActivos();
      $this->arrData['Grados'] = null;
      foreach ($GradosActivos as $key => $grado)
      {
        $this->arrData['Grados'][$grado->id] = $grado->nombre;
      }
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }




}