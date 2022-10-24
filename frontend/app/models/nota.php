<?php
/**
  * Modelo Nota  
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
  */
class Nota extends LiteRecord
{
  use NotaTDefa, NotaTProps,  NotaTLinksOlds;


  protected static $table = 'sweb_notas';
  protected static $tbl_estud = '';
  protected static $tbl_asign = '';
  
  //====================
  public function __construct() {
    self::$tbl_estud = Config::get('tablas.estud');
    self::$tbl_asign = Config::get('tablas.asign');
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
  public function getList() {
    return (new Nota)->all();
  }

  //====================
  public function getNotasSalon(int $salon_id) {
    return (new Nota)->all(
      "SELECT n.*, CONCAT(e.apellido1, \" \", e.apellido2, \" \", e.nombres) AS estudiante
      FROM ".self::$table." as n
      LEFT JOIN ".self::$tbl_estud." AS e ON n.estudiante_id = e.id
      WHERE n.salon_id=? 
      ORDER BY n.periodo_id, e.apellido1, e.apellido2, e.nombres",  array($salon_id)
    );
  } //END-getNotasSalonAsignatura


  //====================
  public function getNotasSalonAsignatura(int $salon_id, int $asignatura_id, $annio=null) {
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


  //====================
  public static function getVistaNotasTodasExportar(int $salon_id) {
    $aResult = [];
    $registros = static::query("SELECT * FROM vista_notas_todas_exportar WHERE salon_id = ?", [$salon_id])->fetchAll();
    foreach ($registros as $reg) {
      $aResult["$reg->salon;$reg->salon_id"]["$reg->estudiante;$reg->estudiante_id"][$reg->periodo_id]["$reg->asignatura;$reg->asignatura_abrev"] = "$reg->definitiva;$reg->plan_apoyo;$reg->nota_final;$reg->desempeno";
    }
    return $aResult;
  } //END-getVistaNotasTodasExportar

}