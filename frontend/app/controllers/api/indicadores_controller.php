<?php
/**
  * Controlador API INDICADORES  
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * @example http://username:password@URL/api/indicadores/all
  */
class IndicadoresController extends RestController
{

  /**
   * Obtiene todos los registros de indicadores
   * @link ../api/indicadores/all
   */
  public function get_all() {
    $this->data = (new Indicador)->getListActivos();
  }//END-get_all

  /**
   * Obtiene todos los registros de indicadores
   * @link ../api/indicadores/list
   */
  public function get_list(int $periodo_id, int $grado_id, int $asignatura_id) {
    $this->data = (new Indicador)->getListIndicadores($periodo_id, $grado_id, $asignatura_id);
  }//END-get_all
  

  public function get_form() {
    $form = 'api: '.__CLASS__;
    $this->data = $form;
  }


  /**
   * Devuelve el indicador buscado por UUID
   * @link ../api/indicadores/singleuuid/3b22fefc7f6afa79c54f
   */
/*   public function get_singleuuid(string $uuid) {
    $record = (new Indicador)->getByUUID($uuid);
    if (isset($record)) {
      $this->data = $record;
    } else {
      $this->error('El registro buscado no existe', 404);
    }
  }//END-get_singleuuid */

  /**
   * Devuelve el indicador buscado por ID
   * @link ../api/indicadores/singleid/168500
   */
  public function get_singleid(int $id) {
    $record = (new Indicador)->getById($id);
    if (isset($record)) {
      $this->data = $record;
    } else {
      $this->error('El registro buscado no existe', 404);
    }
  }//END-get_singleid

} //END-CLASS