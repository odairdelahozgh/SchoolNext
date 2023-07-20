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
    self::$order_by_default = 't.is_active DESC, t.position';
    $this->setUp();
  } //END-__construct

/*   public function getNombreDirector() { 
    $registro = $this::first("SELECT * FROM dm_user WHERE id = :usuario", [":usuario" => $this->director_id]);
    if (!$registro) {
      return false;
    }
    return true;
  } */

  /* 
  public function esDirector(int $user_id) { 
    $registro = $this::first("SELECT * FROM self::$table WHERE director_id = :usuario", [":usuario" => $user_id]);
    if (!$registro) {
      return false;
    }
    return true;
  } */

  /**
   * Devuelve lista de Salones.
   */
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
        ->orderBy(self::$order_by_default);

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
          ->orderBy(self::$order_by_default)
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

} //END-CLASS