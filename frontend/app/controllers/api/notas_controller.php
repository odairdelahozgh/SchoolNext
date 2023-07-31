<?php
/**
  * Controlador API  
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * 
  */
class NotasController extends RestController
{

  public function get_all() {
    $this->data = (new Nota)->all();
  } //END-get_all

  public function get_singleuuid(string $uuid) {
    $record = (new Nota)->getByUUID($uuid);
    if (isset($record)) {
      $this->data = $record;
    } else {
      $this->error('El registro buscado no existe', 404);
    }
  } //END-get_singleuuid

  public function get_singleid(int $id) {
    $record = (new Nota)::get($id);
    if (isset($record)) {
      $this->data = $record;
    } else {
      $this->error('El registro buscado no existe', 404);
    }
  } //END-get_singleid

  public function get_notas_salon(int $salon_id) {
    try {
      $record = (new Nota)->getNotasConsolidado($salon_id);
      if (isset($record)) {
        $this->data = $record;
      } else {
        $this->error("Se se encontraron notas para el salon: $salon_id", 404);
      }
      
    } catch (\Throwable $th) {
      OdaLog::error($th);
      $this->error('EXCEPCION INTERNA CAPTURADA', 404);
    }
  } //END-get_notas_salon

  public function get_notas_grado(int $grado_id, int $annio) {
    try {
      $record = (new Nota)->getNotasConsolidadoByGradoAnnio($grado_id, $annio);
      if (isset($record)) {
        $this->data = $record;
      } else {
        $this->error("No hay notas para el GRADO:$grado_id en el AÑO:$annio", 404);
      }
    
    } catch (\Throwable $th) {
      OdaLog::error($th);
      $this->error('EXCEPCION INTERNA CAPTURADA', 404);
    }
  }//END-get_notas_grado

  public function get_notasprom_periodo_salon(int $periodo_id, int $salon_id) {
    try {
      $record = (new Nota)->getNotasPromAnnioPeriodoSalon($periodo_id, $salon_id);
      if (isset($record)) {
        $this->data = $record;
      } else {
        $this->error("No se encontraron Notras Promedio para el periodo:$periodo_id del salon:$salon_id", 404);
      }
    } catch (\Throwable $th) {
      OdaLog::debug($th, 'api_'.__CLASS__.'-'.__FUNCTION__);
    }
  } //END-get_notasprom_periodo_salon
  
  public function get_salones_annio(int $annio) {
    try {
      $record = (new Nota)->getSalonesByAnnio($annio);
      if (isset($record)) {
        $this->data = $record;
      } else {
        $this->error("No se encontraron SALONES en el AÑO $annio", 404);
      }

    } catch (\Throwable $th) {
      OdaLog::debug($th, 'api_'.__CLASS__.'-'.__FUNCTION__);
    }
  } //END-get_salones_annio

  public function get_grados_annio(int $annio) {
    try {
      $record = (new Nota)->getGradosByAnnio($annio);
      if (isset($record)) {
        $this->data = $record;
      } else {
        $this->error("No se encontraron GRADOS en el AÑO $annio", 404);
      }

    } catch (\Throwable $th) {
      OdaLog::debug($th, 'api_'.__CLASS__.'-'.__FUNCTION__);
    }
  } //END-get_grados_annio


} //END-CLASS