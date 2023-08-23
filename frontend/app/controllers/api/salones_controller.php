<?php
/**
  * Controlador API SALONES  
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * @example http://username:password@URL/api/salones/all
  */
class SalonesController extends RestController
{

  /**
   * Obtiene todos los registros de salones
   * @link ../api/salones/all
   */
  public function get_all() {
    $this->data = (new Salon)->getListActivos();
  }//END-get_all

  public function get_by_coordinador(int $coordinador) {
    $this->data = (new Salon)->getByCoordinador($coordinador); // corregir
  }//END-get_all

} //END-CLASS