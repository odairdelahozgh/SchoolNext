<?php

/**
  * Modelo de Ejemplo  
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
  */

  /*
  id, estudiante_id, annio, periodo_id, grado_id, salon_id, fecha, asunto, 
  acudiente, foto_acudiente, director, foto_director,
  created_at, updated_at, created_by, updated_by
  */
class RegistrosGen extends LiteRecord
{
  protected static $table = 'sweb_estudiantes_reg_observ_gen';
  
  // ===========
  public function getFecha($date_format="d-M-Y") {
    return date($date_format, strtotime($this->fecha));
  } // END-getFecha
  
  
  // ===========
  public function getFotoAcudiente() {
    if (!$this->foto_acudiente) {
      return 'no foto_acudiente';
    }
    $filename = 'registros_generales/'.(($this->created_at) ? date('Y',strtotime($this->created_at)) : date('Y')).'/'.$this->foto_acudiente;
    return OdaTags::fileimg($filename, "class=\"w3-round\" style=\"width:100%;max-width:80px\"");
  } // END-getFotoAcudiente
  
  // ===========
  public function getFotoDirector() {
    if (!$this->foto_director) {
      return 'no foto_director';
    }
    $filename = 'registros_generales/'.(($this->created_at) ? date('Y',strtotime($this->created_at)) : date('Y')).'/'.$this->foto_director;
    return OdaTags::fileimg($filename, "class=\"w3-round\" style=\"width:100%;max-width:80px\"");
  } // END-getFotoDirector


  // ===========
  public function getRegistrosProfesor($user_id) {
    $DQL = "SELECT rg.*, CONCAT(e.nombres,' ',e.apellido1,' ',e.apellido2) as estudiante,
            s.nombre as salon, CONCAT(u.nombres,' ',u.apellido1,' ',u.apellido2) as creador
            FROM ".self::$table." AS rg
            LEFT JOIN ".Config::get('tablas.estud') ." as e ON rg.estudiante_id = e.id
            LEFT JOIN ".Config::get('tablas.salon') ." as s ON rg.salon_id      = s.id
            LEFT JOIN ".Config::get('tablas.user')  ." as u ON rg.created_by    = u.id
            WHERE rg.created_by=$user_id
            ORDER BY rg.fecha desc";
    return $this::all($DQL);
  } // END-getListProfesor

  // =============
  public function getRegistrosProfesorResumen($user_id) {
    $DQL = "SELECT s.nombre AS salon, COUNT(*) AS tot_reg
            FROM ".self::$table." AS rg
            LEFT JOIN ".Config::get('tablas.salon')." as s ON rg.salon_id=s.id
            WHERE rg.created_by=$user_id
            GROUP BY rg.salon_id;";
    return $this::all($DQL);
  } // END-getResumen

  
  // =============
  public function getRegistrosAnnio(int $annio) {
    $annio_actual = Config::get('config.academic.annio_actual');
    $sufijo = ($annio!=$annio_actual) ? '_'.$annio : '' ;

    $DQL = "SELECT rg.*, CONCAT(e.nombres,' ',e.apellido1,' ',e.apellido2) as estudiante,
            s.nombre as salon, CONCAT(u.nombres,' ',u.apellido1,' ',u.apellido2) as creador
            FROM ".self::$table.$sufijo." AS rg
            LEFT JOIN ".Config::get('tablas.estud') ." as e ON rg.estudiante_id = e.id
            LEFT JOIN ".Config::get('tablas.salon') ." as s ON rg.salon_id      = s.id
            LEFT JOIN ".Config::get('tablas.user')  ." as u ON rg.created_by    = u.id
            WHERE annio = $annio
            ORDER BY s.position,estudiante,rg.periodo_id";
    return $this::all($DQL);
  } // END-getRegistrosAnnio
    

} // END-CLASS-RegistrosGen