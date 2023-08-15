<?php
/**
 * Modelo Seguimientos
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

 /* 
  'id', 'uuid', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 
  'definitiva', 'plan_apoyo', 'nota_final', 'profesor_id', 
  
  /// INDICADORES DE SEGUIMIENTOS
  'i21', 'i22', 'i23', 'i24', 'i25', 'i26', 'i27', 'i28', 'i29', 'i30',

  'asi_desempeno', 'asi_activ_profe', 'asi_activ_estud', 'asi_fecha_entrega', 'is_asi_validar_ok', 
  'asi_calificacion', 'is_asi_ok_dirgrupo', 'is_asi_ok_coord', 'asi_link_externo1', 'asi_link_externo2', 
  
  'created_at', 'updated_at', 'created_by', 'updated_by'
*/
  
class Seguimientos extends Nota {

  use SeguimientosTraitProps;

  // public function __construct() {
  //   parent::__construct();
  //   self::$table = Config::get('tablas.nota');
  //   self::$_order_by_defa = 't.periodo_id DESC, t.grado_id, t.salon_id, t.estudiante_id, t.asignatura_id';
  //   $this->setUp();
  // } //END-__construct


  
  public function getByEstudiantePeriodo(int $estudiante_id, int $periodo_id) {
    try {
      $DQL = (new OdaDql(__CLASS__))
        ->select('t.uuid, t.periodo_id, a.nombre as asignatura_nombre')
        ->leftJoin('asignatura', 'a')
        ->where("t.is_psi_validar_ok>=3 AND t.estudiante_id=? AND t.periodo_id=?")
        ->setParams([$estudiante_id, $periodo_id]);
      return $DQL->execute();

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }

  } //END-getSeguimientosByPeriodo
 
 

  public static function getBySalonAsignaturaPeriodos(int $salon_id, int $asignatura_id, array $periodos=[], $annio=null) {
    try {
      $str_p = implode(',', $periodos);
      
      $DQL = (new OdaDql(__CLASS__))
      ->select('t.*')
      ->addSelect('a.nombre as asignatura_nombre')
      ->addSelect('s.nombre as salon_nombre')
      ->concat(['e.nombres', 'e.apellido1', 'e.apellido2'], 'estudiante_nombre')

      ->leftJoin('asignatura', 'a')
      ->leftJoin('salon', 's')
      ->leftJoin('estudiante', 'e')

      ->where("t.periodo_id IN($str_p) AND t.salon_id=? AND t.asignatura_id=?")
      ->setParams([$salon_id, $asignatura_id])
      ->orderBy('t.annio, t.periodo_id DESC, s.nombre, e.apellido1, e.apellido2, e.nombres');
    return $DQL->execute();
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getBySalonAsignaturaPeriodos


} //END-CLASS