<?php
/**
 * Modelo Salon * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * 
 * 'nombre', 'grado_id', 'director_id', 'codirector_id', 'tot_estudiantes', 'position'
 * 'print_state1', 'print_state2', 'print_state3', 'print_state4', 'print_state5', 'is_ready_print', 'print_state', 
 * 'id', 'uuid', 'is_active', 'created_by', 'created_at', 'updated_by', 'updated_at', 
 */
  
class Salon extends LiteRecord {

  use SalonTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.salon');
    self::$_order_by_defa = 't.is_active DESC, t.position';
    $this->setUp();
  } //END-__construct


  public function getList2($estado=null, $select='*', string|bool $order_by=null) { 
    $DQL = "SELECT s.*, g.nombre AS grado, CONCAT(ud.nombres, ' ', ud.apellido1, ' ', ud.apellido2) AS director, 
              CONCAT(uc.nombres, ' ', uc.apellido1, ' ', uc.apellido2) AS codirector 
            FROM ".self::$table." AS s
      LEFT JOIN ".Config::get('tablas.grados')." AS g ON s.grado_id=g.id
      LEFT JOIN ".Config::get('tablas.usuarios')." AS ud ON s.director_id=ud.id
      LEFT JOIN ".Config::get('tablas.usuarios')." AS uc ON s.codirector_id=uc.id";

    if (!is_null($estado)) {
      $DQL .= " WHERE (s.is_active=?) ORDER BY s.position ";
      return $this::all($DQL, array((int)$estado));
    }
    $DQL .= " ORDER BY s.position ";
    return $this::all($DQL);
  } // END-getList


  public function getList(int|bool $estado=null, $select='*', string|bool $order_by=null) { 
    $DQL = new OdaDql(__CLASS__);
    $DQL->select("t.*, g.nombre AS grado_nombre")
        ->concat( ['ud.nombres', 'ud.apellido1', 'ud.apellido2'], 'director_nombre')
        ->concat( ['uc.nombres', 'uc.apellido1', 'uc.apellido2'], 'codirector_nombre')
        ->leftJoin('grado',   'g')
        ->leftJoin('usuario', 'ud', 't.director_id = ud.id')
        ->leftJoin('usuario', 'uc', 't.codirector_id = uc.id')
        ->orderBy(self::$_order_by_defa);

    if (!is_null($estado)) { $DQL->andWhere("t.is_active=$estado"); }

    if (!is_null($order_by)) { 
      $DQL->orderBy($order_by); 
    }
    
    return $DQL->execute();
  } //END-getList

  

  public function getByCoordinador(int $user_id) { 
    try {
      $DQL = new OdaDql(__CLASS__);
      $DQL->select("t.*, g.nombre AS grado_nombre")
          ->concat( ['ud.nombres', 'ud.apellido1', 'ud.apellido2'], 'director_nombre')
          ->concat( ['uc.nombres', 'uc.apellido1', 'uc.apellido2'], 'codirector_nombre')
          ->leftJoin('grado',   'g')
          ->leftJoin('seccion',   's', 'g.seccion_id = s.id')
          ->leftJoin('usuario', 'ud', 't.director_id = ud.id')
          ->leftJoin('usuario', 'uc', 't.codirector_id = uc.id')
          ->orderBy(self::$_order_by_defa)
          ->where("t.is_active=1");
      
      if ($user_id<>1) {
        $DQL->andWhere("s.coordinador_id=?")
          ->setParams([$user_id]);
      }
      return $DQL->execute();
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getList

  public function getByDirector(int $user_id) { 
    try {
      $DQL = new OdaDql(__CLASS__);
      $DQL->select("t.*, g.nombre AS grado_nombre")
          ->concat( ['ud.nombres', 'ud.apellido1', 'ud.apellido2'], 'director_nombre')
          ->concat( ['uc.nombres', 'uc.apellido1', 'uc.apellido2'], 'codirector_nombre')
          ->leftJoin('grado', 'g')
          ->leftJoin('usuario', 'ud', 't.director_id = ud.id')
          ->leftJoin('usuario', 'uc', 't.codirector_id = uc.id')
          ->orderBy(self::$_order_by_defa)
          ->where("t.is_active=1");
      
      if ($user_id<>1) {
        $DQL->andWhere("(t.director_id=? or t.codirector_id=?)")
          ->setParams([$user_id, $user_id]);
      }
      return $DQL->execute();
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-getList

  
      
  //----------------------
  public static function setupCalificarSalon(int $salon_id) {
    $periodo_actual = Config::get('config.academic.annio_actual');
    $annio_actual = Config::get('config.academic.periodo_actual');
    $RegSalon = (new Salon())->get($salon_id);

    $tot_notas = 0;
    if (isset($RegSalon)) {
        $grado = $RegSalon->grado_id;
        // OBTENER TODAS LAS ASIGNATURAS DE ESE SALON (GRADO).
        $DQL = new OdaDql(__CLASS__);
        $DQL->setFrom('sweb_grado_asignat');
        
        if ($periodo_actual==5) {
          $DQL = Doctrine_Core::getTable('GradoAsignatura')->createQuery('GA')
                  ->select('GA.asignatura_id AS asignatura_id')
                  ->where('GA.grado_id=?', $grado);
        } else {
          // EXCLUIR COMPORTAMIENTO (codigo 30) (PERIODOS 1,2,3,4)
          // POLITICA ESTABLECIDA A PARTIR DE 25 ENERO 2017.
          $DQL = Doctrine_Core::getTable('GradoAsignatura')->createQuery('GA')
                  ->select('GA.asignatura_id AS asignatura_id')
                  ->where('GA.grado_id=?', $grado)
                  ->AndWhere('GA.asignatura_id<>?', 30);
        }
        //$query_ga->AndWhere('GA.asignatura_id<>?', 9); // excluir recreacion y deportes
        $reg_asignaturas = $query_ga->fetchArray();

        // OBTENER LOS ESTUDIANTES DE ESE SALON
        $query_e = Doctrine_Core::getTable('Estudiante')->createQuery('E')
                  ->where('E.is_active=1 AND E.salon_id=?', array($RegSalon['id']) );
        $reg_estudiantes = $query_e->execute();
        
        // AGREGAR REGISTROS VACIOS A NOTAS. 
        // RECORRER MATERIAS
        foreach ($reg_estudiantes as $key => $estud) {
          foreach ($reg_asignaturas as $key => $asignat) {
              //if ($asignat['asignatura_id']==41) {  //para incluir una materia especifica que qued�� por fuera !!
                $nota = new Nota();
                $nota->annio         = $annio_actual;
                $nota->periodo_id    = $periodo_actual;
                $nota->grado_id      = $RegSalon['grado_id'];
                $nota->salon_id      = $RegSalon['id'];
                $nota->asignatura_id = $asignat['asignatura_id'];
                $nota->estudiante_id = $estud['id'];
                $nota->save();
                $tot_notas += 1;
            //}
          }
        }
        
      $RegSalon['updated_at'] = date('Y-m-d H:i:s');
      $RegSalon['print_state'.$periodo_actual] = 'En Calificacion';
      $RegSalon->save();
      return $tot_notas;
    }

  } // FIN setupCalificarSalon

  
  public function setNumeroEstudiantes() {
    $tot_estudiantes = (new Estudiante)->getNumEstudiantes_BySalon($this->id);
    $DQL = new OdaDql(__CLASS__);
    $DQL->setFrom('sweb_salones');
    $DQL->update(['tot_estudiantes' => $tot_estudiantes])
        ->where('t.id=?')
        ->setParams([$this->id]);

    $DQL->execute();
  } //END-setNumeroEstudiantes

} //END-CLASS