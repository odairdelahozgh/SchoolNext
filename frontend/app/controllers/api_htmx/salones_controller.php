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
    View::select(null, null);
    $listActivos = (new Salon)->getListActivos();
    $result = '<table>';
    foreach ($listActivos as $key => $salon) {
      $result .= "<tr><td>{$salon->id}</td> <td>{$salon->nombre}</tr>";
    }
    $result .= '</table>';
    //$this->data = $result;
    echo $result;
  }



}