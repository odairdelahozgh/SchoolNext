<?php
/**
  * Controlador
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * @example http://username:password@URL/api/salones/all
  */
class SalonesController extends HtmxController
{

  public function get_activos() 
  {
    View::select('index');
    $this->data = (new Salon)->getListActivos();
  }

  
}