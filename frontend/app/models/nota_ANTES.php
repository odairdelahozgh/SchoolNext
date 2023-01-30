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
  public function __construct() { // mejorar
    self::$tbl_estud = Config::get('tablas.estudiantes');
    self::$tbl_asign = Config::get('tablas.asignaturas');
    //self::$order_by_default = 'nombre ASC';
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

  

  //====================
  public static function getNotasConsolidado(int $salon_id) {
    $aResult = [];

    $sql = "SELECT N.annio AS annio, N.periodo_id AS periodo_id, N.grado_id AS grado_id,
    N.salon_id AS salon_id, N.asignatura_id AS asignatura_id, N.estudiante_id AS estudiante_id,
    concat(E.nombres,' ',E.apellido1,' ',E.apellido2) AS estudiante,
    G.nombre AS grado, S.nombre AS salon, A.nombre AS asignatura, A.abrev AS asignatura_abrev,
    N.definitiva AS definitiva, N.plan_apoyo AS plan_apoyo, N.nota_final AS nota_final,
    IF(N.nota_final<0, \"Error Nota Final <0\", IF(N.nota_final<60, \"Bajo\", IF(N.nota_final<70, \"Basico\", 
    IF(N.nota_final<80, \"Basico +\", IF(N.nota_final<90, \"Alto\", IF(N.nota_final<95, \"Alto +\", 
    IF(N.nota_final<=100, \"Superior\", \"Error Nota Final >100\"))))))) AS desempeno
    
    FROM ((((sweb_notas N LEFT JOIN sweb_asignaturas A on(N.asignatura_id = A.id)) 
    LEFT JOIN sweb_estudiantes E on(N.estudiante_id = E.id)) 
    LEFT JOIN sweb_salones S on(N.salon_id = S.id)) 
    LEFT JOIN sweb_grados G on(N.grado_id = G.id)) 
    
    WHERE N.salon_id = $salon_id

    ORDER BY S.position,E.nombres,E.apellido1,E.apellido2,N.periodo_id,A.abrev";

    $registros = static::query($sql)->fetchAll();
    foreach ($registros as $reg) {
      $aResult["$reg->salon;$reg->salon_id"]["$reg->estudiante;$reg->estudiante_id"][$reg->periodo_id]["$reg->asignatura;$reg->asignatura_abrev"] = "$reg->definitiva;$reg->plan_apoyo;$reg->nota_final;$reg->desempeno";
    }
    return $aResult;
  } //END-getVistaNotasTodasExportar


}