<?php
/**
  * Controlador  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class IndicadoresController extends ScaffoldController
{


  protected function before_filter() 
  {
    $this->nombre_modelo = 'indicador';
  }
 
}
