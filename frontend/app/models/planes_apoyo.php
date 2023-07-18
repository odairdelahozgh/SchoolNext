<?php
/**
 * Modelo PlanesApoyo  
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

 /* 
  'id', 'uuid', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'asignatura_id', 'estudiante_id', 
  'definitiva', 'plan_apoyo', 'nota_final', 'profesor_id', 
  
  /// planes de apoyo
  'i31', 'i32', 'i33', 'i34', 'i35', 'i36', 'i37', 'i38', 'i39', 'i40', 

  'paf_link_externo1', 'paf_link_externo2', 
  'paf_temas', 'paf_acciones', 'paf_activ_estud', 'paf_activ_profe', 'paf_fecha_entrega', 
  'is_paf_ok_coord', 'is_paf_validar_ok', 'is_paf_ok_dirgrupo', 
  
  'created_at', 'updated_at', 'created_by', 'updated_by'
*/
  
class PlanesApoyo extends LiteRecord {

  use PlanesApoyoTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.nota');
    self::$order_by_default = 't.periodo_id, t.grado_id, t.salon_id, t.estudiante_id, t.asignatura_id';
    $this->setUp();
  } //END-__construct


  
  public function getByEstudiantePeriodo(int $estudiante_id, int $periodo_id) {
    try {
      $DQL = (new OdaDql(__CLASS__))
        ->select('t.uuid, a.nombre as asignatura_nombre')
        ->leftJoin('asignatura', 'a')
        ->where("t.is_paf_validar_ok>=3 AND t.estudiante_id=? AND t.periodo_id=?")
        ->setParams([$estudiante_id, $periodo_id]);
      return $DQL->execute();

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }

  } //END-getPlanesApoyoByPeriodo
 
 

  
  // public static function getByClave(string $registro_uuid) {
  //   try {
  //     $DQL = (new OdaDql(__CLASS__))
  //       ->select('t.*')
  //       ->addSelect('s.nombre as salon_nombre')
  //       ->addSelect('g.nombre as grado_nombre')
  //       ->addSelect('a.nombre as asignatura_nombre')
  //       ->concat(['e.nombres', 'e.apellido1', 'e.apellido2'], 'estudiante_nombre')
  //       //->concat(['u.nombres', 'u.apellido1', 'u.apellido2'], 'profesor_nombre')

  //       ->leftJoin('salon', 's')
  //       ->leftJoin('grado', 'g', 't.salon_id=g.id')
  //       ->leftJoin('asignatura', 'a')
  //       ->leftJoin('estudiante', 'e')
  //       //->leftJoin('usuario', 'u', 't.updated_by=u.id')
  //       ->where("t.id=?")
  //       ->setParams([$registro_uuid]);
  //     return $DQL->execute(true);

  //   } catch (\Throwable $th) {
  //     OdaFlash::error($th);
  //   }
    
  // } //END-getByClave
 


} //END-CLASS