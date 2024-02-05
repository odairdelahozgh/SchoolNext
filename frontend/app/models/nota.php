<?php
/**
 * Modelo
 *  
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

include "nota/nota_trait_correcciones.php";
include "nota/nota_trait_links.php";
include "nota/nota_trait_props.php";
include "nota/nota_trait_set_up.php";

class Nota extends LiteRecord {

  use NotaTraitSetUp;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.nota');
    self::$_order_by_defa = 't.annio, t.periodo_id DESC, s.nombre, e.apellido1, e.apellido2, e.nombres';
    $this->setUp();
  }

  
  public function setUpdateCalificacion() 
  {
    try {
      // $this::query(
      //   "UPDATE ".self::$table." SET salon_id=?, grado_id=? WHERE estudiante_id=? ", 
      //   [$RegSalonNuevo->id, $RegSalonNuevo->grado_id, $estudiante_id]
      // )->rowCount() > 0;

    } catch (\Throwable $th) {
      OdaLog::error($th);
    }
  }


  public function cambiarSalonEstudiante(
    int $nuevo_salon_id, 
    int $nuevo_grado_id, 
    int $estudiante_id
  ) 
  {
    $this::query(
      "UPDATE ".self::$table." SET salon_id=$nuevo_salon_id, grado_id=$nuevo_grado_id WHERE estudiante_id=$estudiante_id"
    )->rowCount() > 0;
  }
  

  public function getList(
    int|bool $estado=null, 
    string $select='*', 
    string|bool $order_by=null
  ) 
  {
    $DQL = (new OdaDql(__CLASS__))
        ->select('t.*')
        ->addSelect('CONCAT(e.apellido1, " ", e.apellido2, " ", e.nombres) as estudiante_nombre')
        ->addSelect('s.nombre as salon_nombre')
        ->addSelect('g.nombre as grado_nombre')
        ->addSelect('a.nombre as asignatura_nombre')
        ->leftJoin('estudiante', 'e')
        ->leftJoin('salon', 's')
        ->leftJoin('grado', 'g')
        ->leftJoin('asignatura', 'a')
        ->where('t.salon_id=17')
        ->orderBy(self::$_order_by_defa);

    if (!is_null($order_by)) { 
      $DQL->orderBy($order_by); 
    }
    
    return $DQL->execute();
  }

   
  public function getByPeriodoEstudiante(
    int $periodo_id, 
    int $estudiante_id
  ): array|string 
  {
    $DQL = new OdaDql(__CLASS__);

    $DQL->select('t.id, t.uuid, t.annio, t.periodo_id, t.grado_id, t.salon_id, t.asignatura_id, t.estudiante_id, t.profesor_id, 
          t.definitiva, t.plan_apoyo, t.nota_final, t.i01, t.i02, t.i03, t.i04, t.i05, t.i06, t.i07, t.i08, t.i09, t.i10, 
          t.i11, t.i12, t.i13, t.i14, t.i15, t.i16, t.i17, t.i18, t.i19, t.i20')
        ->addSelect('a.nombre as asignatura_nombre')
        ->concat(['e.nombres', 'e.apellido1', 'e.apellido2'], 'estudiante_nombre')
        ->leftJoin('asignatura', 'a')
        ->leftJoin('estudiante', 'e')
        ->where('t.periodo_id=? AND t.estudiante_id=?')
        ->orderBy('a.nombre')
        ->setParams([$periodo_id, $estudiante_id]);

    return $DQL->execute();
  }


  public function getByAnnioPeriodoEstudiante(
    int $annio, 
    int $periodo_id, 
    int $estudiante_id
  ): array|string 
  {
    $tbl_notas = self::$table.( (!is_null($annio)) ? "_$annio" : '' );
    $DQL = new OdaDql(__CLASS__);
    $DQL->setFrom($tbl_notas);

    $DQL->select('t.id, t.uuid, t.annio, t.periodo_id, t.grado_id, t.salon_id, t.asignatura_id, t.estudiante_id, t.profesor_id, 
          t.definitiva, t.plan_apoyo, t.nota_final, t.i01, t.i02, t.i03, t.i04, t.i05, t.i06, t.i07, t.i08, t.i09, t.i10, 
          t.i11, t.i12, t.i13, t.i14, t.i15, t.i16, t.i17, t.i18, t.i19, t.i20')
        ->addSelect('a.nombre as asignatura_nombre')
        ->concat(['e.nombres', 'e.apellido1', 'e.apellido2'], 'estudiante_nombre')
        ->leftJoin('asignatura', 'a')
        ->leftJoin('estudiante', 'e')
        ->where('t.periodo_id=? AND t.estudiante_id=?')
        ->orderBy('a.nombre')
        ->setParams([$periodo_id, $estudiante_id]);

    return $DQL->execute();
  }


  public function getByPeriodoSalon(
    int $periodo_id, 
    int $salon_id
  ): array|string 
  {
    $DQL = new OdaDql(__CLASS__);

    $DQL->select('t.id, t.uuid, t.annio, t.periodo_id, t.grado_id, t.salon_id, t.asignatura_id, t.estudiante_id, t.profesor_id, 
          t.definitiva, t.plan_apoyo, t.nota_final, t.i01, t.i02, t.i03, t.i04, t.i05, t.i06, t.i07, t.i08, t.i09, t.i10, 
          t.i11, t.i12, t.i13, t.i14, t.i15, t.i16, t.i17, t.i18, t.i19, t.i20')
        ->addSelect('a.nombre as asignatura_nombre')
        ->concat(['e.nombres', 'e.apellido1', 'e.apellido2'], 'estudiante_nombre')
        ->leftJoin('asignatura', 'a')
        ->leftJoin('estudiante', 'e')
        ->where('t.periodo_id=? AND t.salon_id=?')
        ->orderBy('estudiante_nombre, a.nombre')
        ->setParams([$periodo_id, $salon_id]);

    return $DQL->execute();
  }


  public function getByAnnioPeriodoSalon(
    int $annio, 
    int $periodo_id, 
    int $salon_id
  ): array|string 
  {
    $tbl_notas = self::$table.( (!is_null($annio)) ? "_$annio" : '' );
    
    $DQL = new OdaDql(__CLASS__);
    
    $DQL->setFrom($tbl_notas);
    
    $DQL->select('t.id, t.uuid, t.annio, t.periodo_id, t.grado_id, t.salon_id, t.asignatura_id, t.estudiante_id, t.profesor_id, 
          t.definitiva, t.plan_apoyo, t.nota_final, t.i01, t.i02, t.i03, t.i04, t.i05, t.i06, t.i07, t.i08, t.i09, t.i10, 
          t.i11, t.i12, t.i13, t.i14, t.i15, t.i16, t.i17, t.i18, t.i19, t.i20')
        ->addSelect('a.nombre as asignatura_nombre')
        ->concat(['e.nombres', 'e.apellido1', 'e.apellido2'], 'estudiante_nombre')
        ->leftJoin('asignatura', 'a')
        ->leftJoin('estudiante', 'e')
        ->where('t.periodo_id=? AND t.salon_id=?')
        ->orderBy('estudiante_nombre, a.nombre')
        ->setParams([$periodo_id, $salon_id]);

    return $DQL->execute();
  }


  public function getNotasSalon(int $salon_id) 
  {
    return (new Nota)->all(
      "SELECT n.*, CONCAT(e.apellido1, \" \", e.apellido2, \" \", e.nombres) AS estudiante
      FROM sweb_notas as n
      LEFT JOIN ".self::$tbl_estud." AS e ON n.estudiante_id = e.id
      WHERE n.salon_id=? 
      ORDER BY n.periodo_id, e.apellido1, e.apellido2, e.nombres",  array($salon_id)
    );
  }


  public function getNotasSalonAsignatura(
    int $salon_id, 
    int $asignatura_id, 
    $annio=null
  )
  {
    $tbl_notas = self::$table.( (!is_null($annio)) ? "_$annio" : '' );

    return (new Nota)->all("SELECT n.*, CONCAT(e.apellido1, \" \", e.apellido2, \" \", e.nombres) AS estudiante
      FROM $tbl_notas as n
      LEFT JOIN sweb_estudiantes AS e ON n.estudiante_id = e.id
      WHERE n.salon_id=? AND n.asignatura_id=?
      ORDER BY n.annio, n.periodo_id, n.salon_id, e.apellido1, e.apellido2, e.nombres",
      array((int)$salon_id, (int)$asignatura_id)
    );
  }

  
  public static function getBySalonAsignaturaPeriodos(
    int $salon_id, 
    int $asignatura_id, 
    array $periodos=[], 
    $annio=null
  ) 
  {
    $tbl_notas = self::$table.( (!is_null($annio)) ? "_$annio" : '' );
    $str_p = implode(',', $periodos);

    return (new Nota)->all(
      "SELECT t.*, concat(e.apellido1, \" \", e.apellido2, \" \", e.nombres) AS estudiante_nombre,
      s.nombre as salon_nombre, a.nombre as asignatura_nombre
      FROM $tbl_notas as t
      LEFT JOIN sweb_estudiantes AS e ON t.estudiante_id = e.id
      LEFT JOIN sweb_salones AS s ON t.estudiante_id = s.id
      LEFT JOIN sweb_asignaturas AS a ON t.estudiante_id = a.id

      WHERE t.periodo_id IN($str_p) AND t.salon_id=? AND t.asignatura_id=?
      ORDER BY t.annio, t.periodo_id DESC, s.nombre, e.apellido1, e.apellido2, e.nombres",
      array($salon_id, $asignatura_id)
    );
  }


  public static function getVistaNotasTodasExportar(int $salon_id): array 
  {
    $aResult = [];
    $registros = static::query(
      "SELECT * FROM vista_notas_todas_exportar WHERE salon_id = ?", 
      [$salon_id]
    )->fetchAll();
    
    foreach ($registros as $reg) {
      $aResult
        ["$reg->salon;$reg->salon_id"]
        ["$reg->estudiante;$reg->estudiante_id"]
        [$reg->periodo_id]
        ["$reg->asignatura;$reg->asignatura_abrev"] = "$reg->definitiva;$reg->plan_apoyo;$reg->nota_final;$reg->desempeno";
    }

    return $aResult;
  }
  

  public static function getNotasConsolidado(
    int $salon_id, 
    $annio=null
  ) 
  {
    try {
      if (!is_null($annio)) {
        $tbl_notas = 'sweb_notas'.  ( ($annio != Config::get('config.academic.annio_actual')) ? "_$annio" : '' );
      } else {
        $tbl_notas = 'sweb_notas';
      }
  
      $aResult = [];
  
      $sql = "SELECT N.id as id, N.uuid as uuid, N.annio AS annio, N.periodo_id AS periodo_id, N.grado_id AS grado_id,
      N.salon_id AS salon_id, N.asignatura_id AS asignatura_id, N.estudiante_id AS estudiante_id, E.uuid AS estudiante_uuid,
      concat(E.nombres,' ',E.apellido1,' ',E.apellido2) AS estudiante, E.is_active AS is_active, 
      G.nombre AS grado, S.nombre AS salon, S.uuid AS salon_uuid, A.nombre AS asignatura, A.abrev AS asignatura_abrev,
      N.definitiva AS definitiva, N.plan_apoyo AS plan_apoyo, N.nota_final AS nota_final,
      IF(N.nota_final<0, \"Error Nota Final <0\", IF(N.nota_final<60, \"Bajo\", IF(N.nota_final<70, \"Basico\", 
      IF(N.nota_final<80, \"Basico +\", IF(N.nota_final<90, \"Alto\", IF(N.nota_final<95, \"Alto +\", 
      IF(N.nota_final<=100, \"Superior\", \"Error Nota Final >100\"))))))) AS desempeno,
      N.is_asi_validar_ok, N.is_paf_validar_ok
      
      FROM (((($tbl_notas N LEFT JOIN sweb_asignaturas A on(N.asignatura_id = A.id)) 
      LEFT JOIN sweb_estudiantes E on (N.estudiante_id = E.id)) 
      LEFT JOIN sweb_salones S on (N.salon_id = S.id)) 
      LEFT JOIN sweb_grados G on (N.grado_id = G.id)) 
      
      WHERE N.salon_id = $salon_id AND N.asignatura_id<>30 
  
      ORDER BY S.position,E.nombres,E.apellido1,E.apellido2,N.periodo_id,A.orden,A.abrev";
  
      $registros = static::query($sql)->fetchAll();
      foreach ($registros as $reg) {
        $asi  = ($reg->is_asi_validar_ok>=3) ? '1': '0' ;
        $paf  = ($reg->is_paf_validar_ok>=3) ? '1': '0' ;
        $aResult["$reg->salon;$reg->salon_id;$reg->salon_uuid"]
                ["$reg->estudiante;$reg->estudiante_id;$reg->estudiante_uuid;$reg->is_active"]
                ["$reg->periodo_id"]
                ["$reg->asignatura;$reg->asignatura_abrev"] 
        = "$reg->id;$reg->uuid;$reg->definitiva;$reg->plan_apoyo;$reg->nota_final;$reg->desempeno;$asi;$paf";
      }
      return $aResult;
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }


  public static function getNotasPromAnnioPeriodoSalon(
    int $periodo_id, 
    int $salon_id
  ): array|string 
  {
    $DQL = (new OdaDql(__CLASS__))
      ->select('t.periodo_id, a.nombre as asignatura_nombre')
      ->addSelect('round(AVG(if(t.nota_final>0, t.nota_final, t.definitiva)), 2) as avg')
      ->leftJoin('asignatura', 'a')
      ->where('t.asignatura_id NOT IN (30,35,36,37,38,39,40) AND t.periodo_id = ? AND t.salon_id = ?')
      ->groupBy('t.periodo_id, a.nombre')
      ->setParams([$periodo_id, $salon_id]);

    return $DQL->execute();
  }

  
  public static function getSalonesCoordinadorByAnnio(
    int $coordinador_id, 
    int $annio) 
  {
    $tbl_notas = 'sweb_notas'.  ( ($annio != Config::get('config.academic.annio_actual')) ? "_$annio" : '' );

    $DQL = new OdaDql(__CLASS__);

    $DQL->select('DISTINCT t.annio, t.salon_id, s.nombre AS salon_nombre')
        ->leftJoin('salon', 's')
        ->leftJoin('grado', 'g')
        ->leftJoin('seccion', 's2', 'g.seccion_id = s2.id')
        ->groupBy('t.annio, s.nombre')
        ->setFrom($tbl_notas);
   
    if ($coordinador_id<>1) {
      $DQL->andWhere("s2.coordinador_id=?")
          ->setParams([$coordinador_id]);
    }

    return $DQL->execute();
  }


  public static function getSalonesByAnnio(int $annio) 
  {
    $tbl_notas = 'sweb_notas'.  ( ($annio != Config::get('config.academic.annio_actual')) ? "_$annio" : '' );

    $DQL = new OdaDql(__CLASS__);

    $DQL->select('DISTINCT t.annio, t.salon_id, s.nombre AS salon_nombre, max(t.periodo_id) as max_periodos')
        ->leftJoin('salon', 's')
        ->groupBy('t.annio, t.salon_id')
        ->orderBy('t.annio, s.nombre')
        ->setFrom($tbl_notas);

    return $DQL->execute();
  }


  public static function getGradosByAnnio(int $annio) 
  {
    $tbl_notas = 'sweb_notas'.  ( ($annio != Config::get('config.academic.annio_actual')) ? "_$annio" : '' );

    $DQL = new OdaDql(__CLASS__);

    $DQL->select('DISTINCT t.annio, t.grado_id, g.abrev AS grado_abrev, max(t.periodo_id) as max_periodos')
        ->leftJoin('grado', 'g')
        ->groupBy('t.annio, t.grado_id')
        ->orderBy('t.annio, g.orden DESC')
        ->setFrom($tbl_notas);
    
    return $DQL->execute();
  }

  
  public static function getNotasConsolidadoByGradoAnnio(
    int $grado_id, 
    int $annio
  ) 
  {
    try {
      $tbl_notas = 'sweb_notas'.  ( ($annio != Config::get('config.academic.annio_actual')) ? "_$annio" : '' );
  
      $aResult = [];
      $sql = "SELECT N.id, N.annio AS annio, N.periodo_id AS periodo_id, 
      N.salon_id AS salon_id, S.nombre AS salon_nombre, 
      N.grado_id AS grado_id, G.nombre AS grado_nombre, G.abrev AS grado_abrev, 
      N.asignatura_id AS asignatura_id, A.nombre AS asignatura_nombre, A.abrev AS asignatura_abrev,
      N.estudiante_id AS estudiante_id, concat(E.nombres,' ',E.apellido1,' ',E.apellido2) AS estudiante_nombre, E.uuid as estudiante_uuid,
      N.definitiva AS definitiva, N.plan_apoyo AS plan_apoyo, N.nota_final AS nota_final
      FROM $tbl_notas N 
      LEFT JOIN sweb_asignaturas A on N.asignatura_id = A.id
      LEFT JOIN sweb_estudiantes E on N.estudiante_id = E.id
      LEFT JOIN sweb_salones S on N.salon_id = S.id
      LEFT JOIN sweb_grados G on N.grado_id = G.id
      
      WHERE N.grado_id = $grado_id and N.asignatura_id NOT IN (30, 35,36,37,38,39,40)
      ORDER BY G.orden,E.nombres,E.apellido1,E.apellido2,N.periodo_id,A.orden,A.abrev";
  
      $registros = static::query($sql)->fetchAll();
      foreach ($registros as $reg) {
        $aResult["$reg->grado_nombre;$reg->grado_id;$reg->grado_abrev;$reg->salon_nombre;$reg->salon_id"]
                ["$reg->estudiante_nombre;$reg->estudiante_id;$reg->estudiante_uuid"]
                ["$reg->periodo_id"]
                ["$reg->asignatura_nombre;$reg->asignatura_abrev"] 
        = "$reg->id;$reg->definitiva;$reg->plan_apoyo;$reg->nota_final";
      }

      return $aResult;
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }


  public static function getCuadroHonorGeneralPrimariaPDF(
    int $periodo_id, 
    null|int $annio = null
  ): array|string 
  {
    try {
      $annio = $annio ?? config::get('config.academic.annio_actual');
      $secciones = implode(',', (new Seccion)::segSecPrimaria());
      
      $DQL = new OdaDql(__CLASS__);

      $DQL->setFrom('sweb_notas');

      $DQL->select('t.salon_id, t.estudiante_id, s.nombre as salon_nombre, AVG(t.definitiva) as prom')
          ->addSelect("concat(e.nombres,' ',e.apellido1,' ',e.apellido2) AS estudiante_nombre")
          ->leftJoin('salon', 's')
          ->leftJoin('estudiante', 'e')
          ->groupBy('t.salon_id, t.estudiante_id')
          ->where('t.asignatura_id NOT IN (30, 35)')
          ->andWhere("t.annio=$annio AND t.periodo_id=$periodo_id")
          ->aNdWhere("t.grado_id IN (SELECT G1.id FROM sweb_grados G1 WHERE G1.seccion_id IN ($secciones) )")
          ->orderBy('s.nombre ASC, prom DESC');
        
      return $DQL->execute();
        
    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return '';
    }
  }

  
  public static function getCuadroHonorGeneralBachilleratoPDF(int $periodo_id, null|int $annio = null): array|string {
    try {
      $annio = $annio ?? config::get('config.academic.annio_actual');

      $secciones = implode(',', (new Seccion)::segSecBachillerato());
      
      $DQL = new OdaDql(__CLASS__);

      $DQL->setFrom('sweb_notas');

      $DQL->select('t.salon_id, t.estudiante_id, s.nombre as salon_nombre, AVG(t.definitiva) as prom')
          ->addSelect("concat(e.nombres,' ',e.apellido1,' ',e.apellido2) AS estudiante_nombre")
          ->leftJoin('salon', 's')
          ->leftJoin('estudiante', 'e')
          ->groupBy('t.salon_id, t.estudiante_id')
          ->where('t.asignatura_id NOT IN (30, 35)')
          ->andWhere("t.annio=$annio AND t.periodo_id=$periodo_id")
          ->aNdWhere("t.grado_id IN (SELECT G1.id FROM sweb_grados G1 WHERE G1.seccion_id IN ($secciones) )")
          ->orderBy('s.nombre ASC, prom DESC');
      
      return $DQL->execute();
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return '';
    }
  }


  public static function getCuadroHonorPrimariaPDF(int $periodo_id, null|int $annio = null): array|string {
    try {
      $annio = $annio ?? config::get('config.academic.annio_actual');
      $secciones = implode(',', (new Seccion)::segSecPrimaria());
  
      $DQL = new OdaDql(__CLASS__);

      $DQL->setFrom('sweb_notas');

      $DQL->select('t.salon_id, t.estudiante_id, s.nombre as salon_nombre, AVG(t.definitiva) as prom')
          ->addSelect("concat(e.nombres,' ',e.apellido1,' ',e.apellido2) AS estudiante_nombre")
          ->leftJoin('salon', 's')
          ->leftJoin('estudiante', 'e')
          ->groupBy('t.salon_id, t.estudiante_id')
          ->where('t.asignatura_id NOT IN (30, 35)')
          ->andWhere("t.annio=$annio AND t.periodo_id=$periodo_id")
          ->andWhere("t.salon_id IN (SELECT S.id FROM sweb_salones S WHERE S.grado_id IN (SELECT G.id FROM sweb_grados G WHERE G.seccion_id IN ($secciones)))")
          ->andWhere("t.estudiante_id NOT IN ( SELECT DISTINCT P.estudiante_id FROM sweb_notas AS P WHERE P.definitiva<60 AND P.periodo_id=$periodo_id )")
          ->orderBy('prom DESC')
          ->setLimit(10);
      
      return $DQL->execute();
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return '';
    }
  }


  public static function getCuadroHonorBachilleratoPDF(
    int $periodo_id, 
    null|int $annio = null
  ): array|string 
  {
    try {
      $annio = $annio ?? config::get('config.academic.annio_actual');

      $secciones = implode(',', (new Seccion)::segSecBachillerato());
  
      $DQL = new OdaDql(__CLASS__);

      $DQL->setFrom('sweb_notas');

      $DQL->select('t.salon_id, t.estudiante_id, s.nombre as salon_nombre, AVG(t.definitiva) as prom')
          ->addSelect("concat(e.nombres,' ',e.apellido1,' ',e.apellido2) AS estudiante_nombre")
          ->leftJoin('salon', 's')
          ->leftJoin('estudiante', 'e')
          ->groupBy('t.salon_id, t.estudiante_id')
          ->where('t.asignatura_id NOT IN (30, 35)')
          ->andWhere("t.annio=$annio AND t.periodo_id=$periodo_id")
          ->andWhere("t.salon_id IN (SELECT S.id FROM sweb_salones S WHERE S.grado_id IN (SELECT G.id FROM sweb_grados G WHERE G.seccion_id IN ($secciones)))")
          ->andWhere("t.estudiante_id NOT IN ( SELECT DISTINCT P.estudiante_id FROM sweb_notas AS P WHERE P.definitiva<60 AND P.periodo_id=$periodo_id )")
          ->orderBy('prom DESC')
          ->setLimit(10);
      
      return $DQL->execute();
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return '';
    } 
  }



}