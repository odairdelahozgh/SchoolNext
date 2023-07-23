<?php
/**
 * Modelo NotaHist 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * 'id', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 
 * 'definitiva', 'plan_apoyo', 'nota_final', 
 * 'i01', 'i02', 'i03', 'i04', 'i05', 'i06', 'i07', 'i08', 'i09', 'i10', 
 * 'i11', 'i12', 'i13', 'i14', 'i15', 'i16', 'i17', 'i18', 'i19', 'i20', 
 * 'i21', 'i22', 'i23', 'i24', 'i25', 'i26', 'i27', 'i28', 'i29', 'i30', 
 * 'i31', 'i32', 'i33', 'i34', 'i35', 'i36', 'i37', 'i38', 'i39', 'i40' 
 * 'profesor_id', 'acciones', 'desempeno', 'inthoraria', 'ausencias', 
 * 'paf_temas', 'paf_acciones', 
 * 'created_at', 'updated_at', 'created_by', 'updated_by', 
 * 
 */
  
class NotaHist extends LiteRecord {

  use NotaHistTraitSetUp;

  protected static $tbl_estud = '';
  protected static $tbl_asign = '';
  
  //====================
  public function __construct() {
    self::$tbl_estud = Config::get('tablas.estudiantes');
    self::$tbl_asign = Config::get('tablas.asignaturas');
    parent::__construct();
    self::$table = Config::get('tablas.notas_hist');
    $this->setUp();
  } //END-__construct


  //====================
  public function verNota() {
    $color = (new Rango)::getColorRango($this->nota_final);
    $rango = (new Rango)::getRango($this->nota_final);
    $plan_apoyo = ($this->definitiva<60) ? 'Definitiva: '.$this->definitiva.' => Plan de Apoyo: '.$this->plan_apoyo : '' ;
    return "<span class=\"w3-tag w3-round $color\">
              $this->nota_final $rango
            </span> $plan_apoyo ";
  } //END-verNota

  //====================
  public function getfoto() { 
    return IMG_UPLOAD_PATH.'/estudiantes/'.$this->id.'.png'; 
  } //END-getfoto


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
  public static function getBySalonAsignaturaPeriodos($salon_id, $asignatura_id, $periodos=array(), $annio=null) {
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
  } //END-getBySalonAsignaturaPeriodos

  //====================
  public static function getVistaTotalAnniosPeriodosSalones() { // ojo :: pendiente eliminar
    $aResult = [];
    $registros = static::query("SELECT * FROM vista_total_annios_periodos_salones_historico order by annio desc", [])->fetchAll();
    foreach ($registros as $reg) {
      $aResult[$reg->annio][$reg->periodo_id][$reg->salon_id] = "$reg->salon;$reg->total_registros";
    }
    return $aResult;
  } //END-getVistaTotalAnniosPeriodosSalones

  
  //====================
  public static function getTotalAnniosPeriodosSalones() {
    $aResult = [];
    $sql = "SELECT H.annio, H.periodo_id, H.salon_id, S.nombre AS salon,
    count(0) AS total_registros 
    FROM (sweb_notas_historia H LEFT JOIN sweb_salones S ON ((H.salon_id = S.id))) 
    GROUP BY H.annio,H.periodo_id,H.salon_id 
    ORDER BY H.annio DESC,H.periodo_id, S.position";

    $registros = static::query($sql)->fetchAll();
    foreach ($registros as $reg) {
      $aResult[$reg->annio][$reg->periodo_id][$reg->salon_id] = "$reg->salon;$reg->total_registros";
    }
    return $aResult;
  } //END-getTotalAnniosPeriodosSalones


} //END-CLASS