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

  public function get_by_coordinador(int $user_id) {
    $this->data = (new Salon)->getByCoordinador($user_id); // corregir
  }//END-get_all
  public function get_by_director(int $user_id) {
    $this->data = (new Salon)->getByDirector($user_id); // corregir
  }//END-get_all

} //END-CLASS