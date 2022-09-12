<?php
/**
  * Modelo NotaHist
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
  */
class NotaHist extends LiteRecord
{
  protected static $table = 'sweb_notas';
  protected static $tbl_estud = '';
  protected static $tbl_asign = '';
  
  //====================
  public function __construct(
    public int $annio
    ) {
    self::$tbl_estud = Config::get('tablas.estud');
    self::$tbl_asign = Config::get('tablas.asign');
  }

  //====================
  public function __toString() { 
    return $this->id; 
  }

  //====================
  public function verNota() {
    $color = (new Rango)::getColorRango($this->nota_final);
    $rango = (new Rango)::getRango($this->nota_final);
    $plan_apoyo = ($this->definitiva<60) ? 'Definitiva: '.$this->definitiva.' => Plan de Apoyo: '.$this->plan_apoyo : '' ;
    return "<span class=\"w3-tag w3-round $color\">
              $this->nota_final $rango
            </span> $plan_apoyo ";
  }

  //====================
  public function getfoto() { 
    return IMG_UPLOAD_PATH.'/estudiantes/'.$this->id.'.png'; 
  }

  //====================
  public function getIsActiveF() { 
    return (($this->is_active) ? '<i class="bi-check-circle-fill">' : '<i class="bi-x">'); 
  }

  //====================
  public function getList() {
    return (new Nota)->all();
  }

  //====================
  public function getNotasSalonAsignatura($salon_id, $asignatura_id, $annio=null) {
    $tbl_notas = self::$table.( (!is_null($annio)) ? "_$annio" : '' );

    return (new Nota)->all(
      "SELECT n.*, CONCAT(e.apellido1, \" \", e.apellido2, \" \", e.nombres) AS estudiante
      FROM $tbl_notas as n
      LEFT JOIN ".self::$tbl_estud." AS e ON n.estudiante_id = e.id
      WHERE n.salon_id=? AND n.asignatura_id=?
      ORDER BY n.annio, n.periodo_id, n.salon_id, e.apellido1, e.apellido2, e.nombres",
      array((int)$salon_id, (int)$asignatura_id)
    );
  } //END-getNotasSalonAsignatura

  //====================
  public static function getNotasSalonAsignaturaPeriodos($salon_id, $asignatura_id, $periodos=array(), $annio=null) {
    $tbl_notas = self::$table.( (!is_null($annio)) ? "_$annio" : '' );
    $str_p = implode(',', $periodos);
    return (new Nota)->all(
      "SELECT n.*, concat(e.apellido1, \" \", e.apellido2, \" \", e.nombres) AS estudiante
      FROM $tbl_notas as n
      LEFT JOIN ".self::$tbl_estud." AS e ON n.estudiante_id = e.id
      WHERE n.periodo_id IN($str_p) AND n.salon_id=? AND n.asignatura_id=?
      ORDER BY n.annio, n.periodo_id, n.salon_id, e.apellido1, e.apellido2, e.nombres",
      array((int)$salon_id, (int)$asignatura_id)
    );
  } //END-getNotasPeriodoSalonAsignatura



}