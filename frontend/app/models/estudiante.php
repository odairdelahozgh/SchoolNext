<?php
/**
 * Modelo Estudiante * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * 'id', 'is_active', 'mes_pagado', 'is_debe_preicfes', 'is_debe_almuerzos', 'is_deudor', 'is_habilitar_mat', 'salon_id', 'grado_mat', 'numero_mat', 'annio_promovido', 'uuid', 'documento', 'contabilidad_id', 'nombres', 'apellido1', 'apellido2', 'fecha_nac', 'direccion', 'barrio', 'telefono1', 'telefono2', 'email', 'created_at', 'updated_at', 'created_by', 'updated_by', 'tipo_dcto', 'sexo', 'photo', 'ape1ape1', 'retiro', 'fecha_ret', 'mat_bajo_p1', 'mat_bajo_p2', 'mat_bajo_p3', 'mat_bajo_p4', 'email_instit', 'clave_instit', 'annio_pagado'
 */
  
class Estudiante extends LiteRecord {

  use EstudianteTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.estudiante');
    self::$order_by_default = 't.apellido1, t.apellido1, t.nombres';
    $this->setUp();
  } //END-__construct


  const LIM_PAGO_PERIODOS = [ 1 => 4, 2 => 6, 3 => 9, 4 => 11, 5 => 11 ];

  /**
   * Devuelve lista de todos los Registros.
   */
  public function getListEstudiantes(string $orden='a1,a2,n', int|bool $estado=null, string|bool $order_by=null) {
    $orden = str_replace(
      array('n', 'a1', 'a2'),
      array('t.nombres', 't.apellido1', 't.apellido2'),
      $orden
    );

    $nombre_estud = "CONCAT(a1, ' ', a2, ' ', n)";
    $nombre_estud = str_replace(
      array('n', 'a1', 'a2'),
      array('t.nombres', 't.apellido1', 't.apellido2'),
      $nombre_estud
    );    
    $DQL = (new OdaDql(__CLASS__))
        ->select('t.*, '.$nombre_estud.' as estudiante_nombre,'.$nombre_estud.' as nombre')
        ->addSelect('s.nombre AS salon_nombre, s.grado_id, g.nombre AS grado_nombre')
        ->leftJoin('datosestud', 'de', 't.id=de.estudiante_id')
        ->leftJoin('salon', 's')
        ->leftJoin('grado', 'g', 's.grado_id=g.id')
        ->orderBy('g.orden,'.$orden);
        
    if (!is_null($order_by)) { $DQL->orderBy($order_by); }
    if (!is_null($estado))   { $DQL->where('t.is_active=?')->setParams([$estado]); }
    return $DQL->execute();
  } // END-getListEstudiantes

  public function getListSecretaria(string $orden='a1,a2,n', int|bool $estado=null, string|bool $order_by=null) {
    $orden = str_replace(
      array('n', 'a1', 'a2'),
      array('t.nombres', 't.apellido1', 't.apellido2'),
      $orden
    );

    $nombre_estud = "CONCAT(a1, ' ', a2, ' ', n)";
    $nombre_estud = str_replace(
      array('n', 'a1', 'a2'),
      array('t.nombres', 't.apellido1', 't.apellido2'),
      $nombre_estud
    );    
    $DQL = (new OdaDql(__CLASS__))
        ->select('t.*, s.grado_id, '.$nombre_estud.' as estudiante_nombre, '
        .'de.madre, de.madre_id, de.madre_tel_1, de.madre_email, de.padre, de.padre_id, de.padre_tel_1, de.padre_email')
        ->addSelect("s.nombre AS salon_nombre, g.nombre AS grado_nombre")
        ->leftJoin('datosestud', 'de', 't.id=de.estudiante_id')
        ->leftJoin('salon', 's')
        ->leftJoin('grado', 'g', 's.grado_id=g.id')
        ->orderBy('g.orden,'.$orden);
        
    if (!is_null($order_by)) { $DQL->orderBy($order_by); }
    if (!is_null($estado))   { $DQL->where('t.is_active=?')->setParams([$estado]); }
    return $DQL->execute();
  } // END-getListSecretaria


  public function getListContabilidad(string $orden='a1,a2,n', int|bool $estado=null, string|bool $order_by=null) {
    $orden = str_replace(
      array('n', 'a1', 'a2'),
      array('t.nombres', 't.apellido1', 't.apellido2'),
      $orden
    );

    $nombre_estud = "CONCAT(a1, ' ', a2, ' ', n)";
    $nombre_estud = str_replace(
      array('n', 'a1', 'a2'),
      array('t.nombres', 't.apellido1', 't.apellido2'),
      $nombre_estud
    );    
    $DQL = (new OdaDql(__CLASS__))
        ->select('t.*, s.grado_id, '.$nombre_estud.' as estudiante_nombre, '
        .'de.madre, de.madre_id, de.madre_tel_1, de.madre_email, de.padre, de.padre_id, de.padre_tel_1, de.padre_email')
        ->addSelect("s.nombre AS salon_nombre, g.nombre AS grado_nombre")
        ->leftJoin('datosestud', 'de', 't.id=de.estudiante_id')
        ->leftJoin('salon', 's')
        ->leftJoin('grado', 'g', 's.grado_id=g.id')
        ->orderBy('g.orden,'.$orden);
        
    if (!is_null($order_by)) { $DQL->orderBy($order_by); }
    if (!is_null($estado))   { $DQL->where('t.is_active=?')->setParams([$estado]); }
    return $DQL->execute();
  } // END-getListContabilidad


  public function getListSicologia(string $orden='a1,a2,n', int|bool $estado=null, string|bool $order_by=null) {
    $orden = str_replace(
      array('n', 'a1', 'a2'),
      array('t.nombres', 't.apellido1', 't.apellido2'),
      $orden
    );

    $nombre_estud = "CONCAT(a1, ' ', a2, ' ', n)";
    $nombre_estud = str_replace(
      array('n', 'a1', 'a2'),
      array('t.nombres', 't.apellido1', 't.apellido2'),
      $nombre_estud
    );    
    $DQL = (new OdaDql(__CLASS__))
        ->select('t.*, s.grado_id, '.$nombre_estud.' as estudiante_nombre, '
        .'de.madre, de.madre_id, de.madre_tel_1, de.madre_email, de.padre, de.padre_id, de.padre_tel_1, de.padre_email')
        ->addSelect("s.nombre AS salon_nombre, g.nombre AS grado_nombre")
        ->leftJoin('datosestud', 'de', 't.id=de.estudiante_id')
        ->leftJoin('salon', 's')
        ->leftJoin('grado', 'g', 's.grado_id=g.id')
        ->orderBy('g.orden,'.$orden);
        
    if (!is_null($order_by)) { $DQL->orderBy($order_by); }
    if (!is_null($estado))   { $DQL->where('t.is_active=?')->setParams([$estado]); }
    return $DQL->execute();
  } // END-getListSicologia



  public function getListEnfermeria(string $orden='a1,a2,n', int|bool $estado=null, string|bool $order_by=null) {
    $orden = str_replace(
      array('n', 'a1', 'a2'),
      array('t.nombres', 't.apellido1', 't.apellido2'),
      $orden
    );

    $nombre_estud = "CONCAT(a1, ' ', a2, ' ', n)";
    $nombre_estud = str_replace(
      array('n', 'a1', 'a2'),
      array('t.nombres', 't.apellido1', 't.apellido2'),
      $nombre_estud
    );    
    $DQL = (new OdaDql(__CLASS__))
        ->select('t.*, s.grado_id, '.$nombre_estud.' as estudiante_nombre, '
        .'de.madre, de.madre_id, de.madre_tel_1, de.madre_email, de.padre, de.padre_id, de.padre_tel_1, de.padre_email')
        ->addSelect("s.nombre AS salon_nombre, g.nombre AS grado_nombre")
        ->leftJoin('datosestud', 'de', 't.id=de.estudiante_id')
        ->leftJoin('salon', 's')
        ->leftJoin('grado', 'g', 's.grado_id=g.id')
        ->orderBy('g.orden,'.$orden);
        
    if (!is_null($order_by)) { $DQL->orderBy($order_by); }
    if (!is_null($estado))   { $DQL->where('t.is_active=?')->setParams([$estado]); }
    return $DQL->execute();
  } // END-getListEnfermeria


  /**
   * 
   */
  public function getListPorProfesor(int $user_id): array {
    $salones = '';
    $CargaProfe = (new CargaProfesor)->getSalonesCarga($user_id);
    foreach ($CargaProfe as $carga) {
      $salones .= $carga->salon_id.",";
    }
    $salones = substr($salones,0,-1);
    $DQL = "SELECT e.*, s.nombre as salon
            FROM ".self::$table." as e
            LEFT JOIN ".Config::get('tablas.salones')." as s ON e.salon_id=s.id
            WHERE s.id IN($salones)";
    return $this::all($DQL);
  } // END-getListPorProfesor

  
    /**
     * 
     */
    public function getSalonesCambiar(string $modulo): string {
      $lnk_cambio = '';
      if ($this->is_active) {
        //35=>'10-B',
        //23=>'01-C', ,29=>'02-C' 30=>'03-C' 32=>'04-C' 33=>'05-C', 
        //11=>'PK-B' 13=>'KD-B' 22=>'KD-C', 14=>'TN-B'
        //2=>'01-B', 
          $salonesSig = array(
              0 => array(),
              1 => array(1=>'01-A', 3=>'02-A',4=>'02-B'),
              2 => array(3=>'02-A',4=>'02-B',  5=>'03-A',6=>'03-B'),
              3 => array(5=>'03-A',6=>'03-B',  7=>'04-A',24=>'04-B'),
              4 => array(7=>'04-A',24=>'04-B', 8=>'05-A',26=>'05-B'),
              5 => array(8=>'05-A',26=>'05-B', 21=>'06-A',25=>'06-B'),
              6 => array(21=>'06-A',25=>'06-B', 20=>'07-A',28=>'07-B'),
              7 => array(20=>'07-A',28=>'07-B', 19=>'08-A',31=>'08-B'),
              8 => array(19=>'08-A',31=>'08-B', 18=>'09-A',34=>'09-B'),
              9 => array(18=>'09-A',34=>'09-B', 17=>'10-A', 35=>'10-B'),
              10 => array(17=>'10-A', 35=>'10-B', 16=>'11-A',36=>'11-B'),
              11 => array(16=>'11-A',36=>'11-B'),
              12 => array(15=>'PV-A', 10=>'PK-A'),
              13 => array(10=>'PK-A', 12=>'KD-A'),
              14 => array(12=>'KD-A', 9=>'TN-A'),
              15 => array(9=>'TN-A',  1=>'01-A'),
          );

          if ( array_key_exists($this->grado_mat, $salonesSig) ) {
            foreach ($salonesSig[$this->grado_mat] as $key_salon => $salon_nombre) {
              $lnk_cambio .= Html::link("$modulo/cambiar_salon_estudiante/$this->id/$key_salon/", $salon_nombre, 'class="btn btn-success btn-sm"').'  ';
            }
          }

      }
      return $lnk_cambio;
  }

  /**
   * CAMBIA DE SALÓN UN ESTUDIANTE
   */
  public function setCambiarSalon(int $estudiante_id, int $nuevo_salon_id, bool $cambiar_en_notas=true): bool {
    try {
      $RegSalonNew = (new Salon)->get($nuevo_salon_id);
      if ($RegSalonNew) {
          $RegEstud = (new Estudiante)->get($estudiante_id);
          $RegEstud->salon_id  = $RegSalonNew->id;
          $RegEstud->grado_mat = $RegSalonNew->grado_id;
          $RegEstud->save();
          if ($cambiar_en_notas) {
            (new Nota)->cambiarSalonEstudiante($nuevo_salon_id, $estudiante_id);
            (new RegistrosGen)->cambiarSalonEstudiante($nuevo_salon_id, $estudiante_id);
            (new RegistroDesempAcad)->cambiarSalonEstudiante($nuevo_salon_id, $estudiante_id);
          }
          return true; // para acá
      }
    } catch (\Throwable $th) {
      OdaLog::error($th);
    }
    return false;
  } //END-setCambiarSalon
  
  /**
   * 
   */
  public function setActualizarPago(int $estudiante_id): bool {
    $RegEstud = (new Estudiante)->get($estudiante_id);
    if ($RegEstud) {
      $periodo_actual = (int)Config::get('config.academic.periodo_actual');
      $RegEstud->mes_pagado = self::LIM_PAGO_PERIODOS[$periodo_actual];
      $RegEstud->save();
      return true;
    }
    return false;
  } // END-setActualizarPago 
 


}//END-CLASS