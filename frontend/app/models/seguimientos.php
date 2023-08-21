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
      $ok = self::$asi_valido;
      $DQL = (new OdaDql(__CLASS__))
        ->select('t.uuid, t.periodo_id, a.nombre as asignatura_nombre')
        ->leftJoin('asignatura', 'a')
        ->where(" (t.is_asi_validar_ok>=$ok) AND (t.estudiante_id=?) AND (t.periodo_id=?)")
        ->setParams([$estudiante_id, $periodo_id]);
      return $DQL->execute();

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }

  } //END-getByEstudiantePeriodo

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

  
  public static function getConsolidadoBySalonPeriodo(string $salon_uuid, int $periodo) {
    try {
      $ok = self::$asi_valido;
      $RegSalon = (new Salon)::getByUUID($salon_uuid);
      $GradoAsig = (new GradoAsignatura())->getByGrado($RegSalon->grado_id);

      $DQL = (new OdaDql(__CLASS__))
      ->select('t.estudiante_id, t.asi_activ_profe, t.asi_activ_estud, t.asi_fecha_entrega, t.is_asi_validar_ok')
      ->concat(['e.apellido1', 'e.apellido2', 'e.nombres'], 'estudiante_nombre')
      ->leftJoin('estudiante', 'e')
      ->where("(t.periodo_id = ?) AND (t.salon_id=?) AND (t.is_asi_validar_ok>=$ok)")
      ->setParams([$periodo, $RegSalon->id])
      ->orderBy('e.apellido1, e.apellido2, e.nombres');
      
      $DQL->setFrom('sweb_notas');

      foreach ($GradoAsig as $key => $grado_asignat) {
        $cnt = $key+1;
        $DQL->addSelect("
        ( SELECT t$cnt.asi_desempeno 
          FROM sweb_notas AS t$cnt
          WHERE 
            (t$cnt.periodo_id = t.periodo_id) AND 
            (t$cnt.salon_id = t.periodo_id) AND 
            (t$cnt.estudiante_id = t.estudiante_id) AND 
            (t$cnt.asignatura_id = t.asignatura_id) AND 
            (t$cnt.asignatura_id =  $grado_asignat->asignatura_id)
          LIMIT 1) as $grado_asignat->asignatura_abrev
        ");
      }

    return $DQL->execute(true);
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getBySalonAsignaturaPeriodos


// public static function getAccionesSegtoAsignaturas_ByPeriodoSalon($periodo=0, $salon=0, $ok_enviar=1) {
//     $var_select = 'n.estudiante_id, a.nombre, concat(e.nombres, " ", e.apellido1, " ", e.apellido2) as estudiante, a.abrev as abrev, n.asi_activ_profe, n.asi_activ_estud, n.asi_fecha_entrega, 
//       n.asi_num_envios, n.is_asi_validar_ok ';
//     $DQL = Doctrine_Core::getTable('Nota')->createQuery('n')->select($var_select);
//     foreach ($RecsGradoAsig as $key => $value) {
//       $cnt = $key+1;
//       $select[$cnt] = ' (SELECT n'.$cnt.'.asi_desempeno 
//                             FROM Nota n'.$cnt.' 
//                           WHERE n'.$cnt.'.periodo_id = n.periodo_id AND 
//                                 n'.$cnt.'.salon_id = n.salon_id AND 
//                                 n'.$cnt.'.estudiante_id = n.estudiante_id AND
//                                 n'.$cnt.'.asignatura_id = n.asignatura_id AND 
//                                 n'.$cnt.'.asignatura_id='.$value['asignatura_id'].' LIMIT 1) as '.$value['asignatura_abrev'];
//       $DQL->addSelect($select[$cnt]);
//     }

//     $DQL->leftJoin('n.Estudiante e')
//               ->leftJoin('n.Asignatura a')
//               ->addWhere('n.periodo_id=? AND n.salon_id=? ', array($periodo, $salon))
//               ->addWhere('n.is_asi_validar_ok>=?', $ok_enviar)
//               ->groupBy('n.estudiante_id, a.nombre')
//               ->orderBy('e.nombres, e.apellido1, e.apellido2, a.nombre');
//     $registros = getTipoResultQuery($DQL, 'array');
//     return $registros;
// }

} //END-CLASS