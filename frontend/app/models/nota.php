<?php
/**
 * Modelo Nota 
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

  setActivar(), setDesactivar()
  getById(), deleteById(), getList(), getListActivos(), getListInactivos()
  getByUUID(), deleteByUUID(), setUUID_All_ojo()

  Para debuguear: debug, warning, error, alert, critical, notice, info, emergence
  OdaLog::debug(msg: "Mensaje", name_log:'nombre_log');
  
  id, uuid, annio, periodo_id, grado_id, salon_id, asignatura_id, estudiante_id, asignatura, estudiante, email_envios, asi_num_envios, 
  definitiva, plan_apoyo, nota_final, profesor_id, 
  i01, i02, i03, i04, i05, i06, i07, i08, i09, i10, i11, i12, i13, i14, i15, i16, i17, i18, i19, i20, 
  
  asi_desempeno, asi_activ_profe, asi_activ_estud, asi_fecha_entrega, is_asi_validar_ok, 
  asi_calificacion, is_asi_ok_dirgrupo, is_asi_ok_coord, asi_link_externo1, asi_link_externo2, 
  i21, i22, i23, i24, i25, i26, i27, i28, i29, i30, 
  paf_link_externo1, paf_link_externo2, 
  paf_temas, paf_acciones, paf_activ_estud, paf_activ_profe, paf_fecha_entrega, 

  is_paf_ok_coord, is_paf_validar_ok, is_paf_ok_dirgrupo, paf_num_envios, 
  i31, i32, i33, i34, i35, i36, i37, i38, i39, i40, 
  ausencias, inthoraria, created_at, updated_at, created_by, updated_by

*/

class Nota extends LiteRecord
{
  use TraitUuid, NotaTraitCallBacks, NotaTraitDefa, NotaTraitProps,  NotaTraitLinksOlds;  
  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.nota');
    self::$_defaults     = $this->getTDefaults();
    self::$_labels       = $this->getTLabels();
    self::$_placeholders = $this->getTPlaceholders();
    self::$_helps        = $this->getTHelps();
    self::$_attribs      = $this->getTAttribs();
    self::$class_name = __CLASS__;
    self::$order_by_default = 't.periodo_id, t.grado_id, t.salon_id, t.estudiante_id, t.asignatura_id';
  } //END-

  
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
      FROM sweb_notas as n
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
      LEFT JOIN sweb_estudiantes AS e ON n.estudiante_id = e.id
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
      LEFT JOIN sweb_estudiantes AS e ON n.estudiante_id = e.id
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




} //END-CLASS