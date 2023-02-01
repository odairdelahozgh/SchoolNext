<?php
/**
 * Modelo RegistrosGen * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

 /* 
  // ->create(array $data = []): bool {}
  // ->update(array $data = []): bool {}
  // ->save(array $data = []): bool {}
  // ::delete($pk): bool
  //
  // ::get($pk, $fields = '*')
  // ::all(string $sql = '', array $values = []): array
  // ::first(string $sql, array $values = []): static
  // ::filter(string $sql, array $values = []): array

  // setActivar, setDesactivar
  // getById, deleteById, getList, getListActivos, getListInactivos
  // getByUUID, deleteByUUID, setUUID_All_ojo

  id, uuid, estudiante_id, annio, periodo_id, grado_id, salon_id, 
  fecha, asunto, acudiente, foto_acudiente, director, foto_director, 
  created_at, updated_at, created_by, updated_by

*/

class RegistrosGen extends LiteRecord
{
  use TraitUuid, RegistrosGenTraitCallBacks, RegistrosGenTraitDefa, RegistrosGenTraitProps,  RegistrosGenTraitLinksOlds;
  
  // Para debuguear: debug, warning, error, alert, critical, notice, info, emergence
  // OdaLog::debug(msg: "Mensaje", name_log:'nombre_log'); 
  
  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.estud_reg_obs_gen');
    self::$_defaults     = $this->getTDefaults();
    self::$_labels       = $this->getTLabels();
    self::$_placeholders = $this->getTPlaceholders();
    self::$_helps        = $this->getTHelps();
    self::$_attribs      = $this->getTAttribs();
    self::$class_name = __CLASS__;
    self::$order_by_default = 't.annio, t.grado_id, t.estudiante_id, t.fecha DESC, ';
  } //END-__construct
  
  public static $periodos = [1=>'Periodo 1', 2=>'Periodo 2', 3=>'Periodo 3', 4=>'Periodo 4'];

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
            LEFT JOIN ".Config::get('tablas.estudiantes') ." as e ON rg.estudiante_id = e.id
            LEFT JOIN ".Config::get('tablas.salones') ." as s ON rg.salon_id      = s.id
            LEFT JOIN ".Config::get('tablas.usuarios')  ." as u ON rg.created_by    = u.id
            WHERE rg.created_by=$user_id
            ORDER BY rg.fecha desc";
    return $this::all($DQL);
  } // END-getListProfesor

  // =============
  public function getRegistrosProfesorResumen($user_id) {
    $DQL = "SELECT s.nombre AS salon, COUNT(*) AS tot_reg
            FROM ".self::$table." AS rg
            LEFT JOIN ".Config::get('tablas.salones')." as s ON rg.salon_id=s.id
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
            LEFT JOIN ".Config::get('tablas.estudiantes') ." as e ON rg.estudiante_id = e.id
            LEFT JOIN ".Config::get('tablas.salones') ." as s ON rg.salon_id      = s.id
            LEFT JOIN ".Config::get('tablas.usuarios')  ." as u ON rg.created_by    = u.id
            WHERE annio = $annio
            ORDER BY s.position,estudiante,rg.periodo_id";
    return $this::all($DQL);
  } // END-getRegistrosAnnio
    

} //END-CLASS