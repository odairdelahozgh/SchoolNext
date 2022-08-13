<?php
/**
  * Modelo Estudiante  
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
  */

/* id, is_active, documento, contabilidad_id, mes_pagado, nombres, apellido1, apellido2, 
   salon_id, is_deudor, photo, fecha_nac, direccion, barrio, telefono1, telefono2, email, 
   created_at, updated_at, created_by, updated_by, tipo_dcto, sexo, grado_mat, numero_mat, 
   ape1ape1, retiro, fecha_ret, is_debe_preicfes, is_debe_almuerzos, is_habilitar_mat, 
   annio_promovido, mat_bajo_p1, mat_bajo_p2, mat_bajo_p3, mat_bajo_p4, 
   email_instit, clave_instit
 */
class Estudiante extends LiteRecord
{
  use EstudianteTDefa, EstudianteTProps,  EstudianteTLinksOlds;

  protected static $table = 'sweb_estudiantes';

  public function __construct() {
    parent::__construct();
    self::$default_foto_estud        = '<img src="/img/upload/estudiantes/user.png" alt="" class="w3-round" style="width:100%;max-width:80 px">';
    self::$default_foto_estud_circle = '<img src="/img/upload/estudiantes/user.png" alt="" class="w3-circle w3-bar-item" style="width:100%;max-width:80 px">';
    self::$_defaults     = $this->getTDefaults();
    self::$_labels       = $this->getTLabels();
    self::$_placeholders = $this->getTPlaceholders();
    self::$_helps        = $this->getTHelps();
    self::$_attribs      = $this->getTAttribs();
  }

  
  //==============
  public function getList(mixed $estado=null, string $orden='a1,a2,n'): array {
    $orden = str_replace(
      array('n', 'a1', 'a2'),
      array('e.nombres', 'e.apellido1', 'e.apellido2'),
      $orden
    );

    $nombre_estud = "CONCAT(a1, ' ', a2, ' ', n)";
    $nombre_estud = str_replace(
      array('n', 'a1', 'a2'),
      array('e.nombres', 'e.apellido1', 'e.apellido2'),
      $nombre_estud
    );

    
    $salon = (self::$session_username=='admin') ? " CONCAT('[',s.id,'] ',s.nombre) AS salon " : " s.nombre AS salon " ;
    $grado = (self::$session_username=='admin') ? " CONCAT('[',g.id,'] ',g.nombre) AS grado " : " g.nombre  AS grado " ;

    if (is_null($estado)) { // todos
      $DQL = "SELECT e.*, $nombre_estud AS nombre_estudiante, $salon, $grado
      FROM ".self::$table." AS e
      LEFT JOIN ".Config::get('tablas.salon')." AS s ON e.salon_id=s.id
      LEFT JOIN ".Config::get('tablas.grado')." AS g ON e.grado_mat=g.id
      ORDER BY $orden";
      return $this::all($DQL);
    } else {
      $DQL = "SELECT e.*, $nombre_estud AS nombre_estudiante, $salon, $grado
      FROM ".self::$table." AS e
      LEFT JOIN ".Config::get('tablas.salon')." AS s ON e.salon_id=s.id
      LEFT JOIN ".Config::get('tablas.grado')." AS g ON e.grado_mat=g.id
      WHERE e.is_active=?
      ORDER BY $orden";
      
      return $this::all($DQL, array((int)$estado));
    }

  } // END-getList
  

  //==============
  public function getListActivos(string $orden='a1,a2,n'): array {
    $orden = str_replace(
      array('n', 'a1', 'a2'),
      array('e.nombres', 'e.apellido1', 'e.apellido2'),
      $orden
    );

    $nombre_estud = "CONCAT(a1, ' ', a2, ' ', n)";
    $nombre_estud = str_replace(
      array('n', 'a1', 'a2'),
      array('e.nombres', 'e.apellido1', 'e.apellido2'),
      $nombre_estud
    );
    
    $salon = (self::$session_username=='admin') ? " CONCAT('[',s.id,'] ',s.nombre) AS salon " : " s.nombre  AS salon " ;
    $grado = (self::$session_username=='admin') ? " CONCAT('[',g.id,'] ',g.nombre) AS grado " : " g.nombre  AS grado " ;
    $DQL = "SELECT e.*, $nombre_estud AS nombre_estudiante, $salon, $grado
      FROM ".self::$table." AS e
      LEFT JOIN ".Config::get('tablas.salon')." AS s ON e.salon_id=s.id
      LEFT JOIN ".Config::get('tablas.grado')." AS g ON e.grado_mat=g.id
      WHERE e.is_active=1
      ORDER BY $orden";
    
    return $this::all($DQL);
  } // END-getList
  
  
  //==============
  public function getListInactivos(string $orden='a1,a2,n'): array {
    $orden = str_replace(
      array('n', 'a1', 'a2'),
      array('e.nombres', 'e.apellido1', 'e.apellido2'),
      $orden
    );

    $nombre_estud = "CONCAT(a1, ' ', a2, ' ', n)";
    $nombre_estud = str_replace(
      array('n', 'a1', 'a2'),
      array('e.nombres', 'e.apellido1', 'e.apellido2'),
      $nombre_estud
    );

    $grado = (self::$session_username=='admin') ? " CONCAT('[',g.id,'] ',g.nombre) AS grado " : " g.nombre  AS grado " ;
    $DQL = "SELECT e.*, $nombre_estud AS nombre_estudiante, $grado
      FROM ".self::$table." AS e
      LEFT JOIN ".Config::get('tablas.grado')." AS g ON e.grado_mat=g.id
      WHERE e.is_active=0
      ORDER BY $orden";
    
    return $this::all($DQL);
  } // END-getList
  

  //=============
  public function getListPorProfesor(int $user_id): array {
    $salones = '';
    $CargaProfe = (new CargaProfesor)->getSalonesCarga($user_id);
    foreach ($CargaProfe as $key => $carga) {
      $salones .= $carga->salon_id.",";
    }
    $salones = substr($salones,0,-1);
    $DQL = "SELECT e.*, s.nombre as salon
            FROM ".self::$table." as e
            LEFT JOIN ".Config::get('tablas.salon')." as s ON e.salon_id=s.id
            WHERE s.id IN($salones)";
    return $this->data = $this::all($DQL);
  } // END-

  
    //=========
    public function getSalonesCambiar(string $modulo): string {
      $lnk_cambio = '';
      if ($this->is_active) {
        //35=>'10-B',
        //23=>'01-C', ,29=>'02-C' 30=>'03-C' 32=>'04-C' 33=>'05-C', 
        //11=>'PK-B' 13=>'KD-B' 22=>'KD-C', 14=>'TN-B'
          $salonesSig = array(
              0 => array(),
              1 => array(1=>'01-A',2=>'01-B',  3=>'02-A',4=>'02-B'),
              2 => array(3=>'02-A',4=>'02-B',  5=>'03-A',6=>'03-B'),
              3 => array(5=>'03-A',6=>'03-B',  7=>'04-A',24=>'04-B'),
              4 => array(7=>'04-A',24=>'04-B', 8=>'05-A',26=>'05-B'),
              5 => array(8=>'05-A',26=>'05-B', 21=>'06-A',25=>'06-B'),
              6 => array(21=>'06-A',25=>'06-B', 20=>'07-A',28=>'07-B'),
              7 => array(20=>'07-A',28=>'07-B', 19=>'08-A',31=>'08-B'),
              8 => array(19=>'08-A',31=>'08-B', 18=>'09-A',34=>'09-B'),
              9 => array(18=>'09-A',34=>'09-B', 17=>'10-A'),
              10 => array(17=>'10-A', 16=>'11-A',36=>'11-B'),
              11 => array(16=>'11-A',36=>'11-B'),
              12 => array(15=>'PV-A', 10=>'PK-A'),
              13 => array(10=>'PK-A', 12=>'KD-A'),
              14 => array(12=>'KD-A', 9=>'TN-A'),
              15 => array(9=>'TN-A',  1=>'01-A',2=>'01-B'),
          );

          if ( array_key_exists($this->grado_mat, $salonesSig) ) {
            foreach ($salonesSig[$this->grado_mat] as $key_salon => $salon_nombre) {
              $lnk_cambio .= Html::link("$modulo/cambiar_salon_estudiante/$this->id/$key_salon/", $salon_nombre, 'class="btn btn-success btn-sm"').'  ';
            }
          }

      }
      return $lnk_cambio;
  }

  public function setCambiarSalon(int $salon_id, bool $cambiar_en_notas=false): bool {
      $salon = (new Salon)->get((int) $salon_id);
      if ($salon) {
          // Cambia el salón en la tabla de ESTUDIANTES
          $this->salon_id  = $salon->id;
          $this->grado_mat = $salon->grado_id;
          $this->save();
          // Lo debe cambiar de salón en la tabla NOTAS también.
          $RegNotaEstud = (new Nota);
          if ($cambiar_en_notas) {
            $RegNotaEstud->Filter("WHERE estudiante_id=?", array($this->id));
            foreach ($RegNotaEstud as $nota) {
              $nota->salon_id = $salon->id;
              $nota->grado_id = $salon->grado_id;
              $nota->save();
            }
          }
          return true;
      }
      return false;
  }
  
  
  public function setActualizarPago(int $estudiante_id): bool {
    $RegEstud = (new Estudiante)->get((int)$estudiante_id);
    if ($RegEstud) {
      $RegEstud->mes_pagado = 6;
      $RegEstud->save();
      return true;
    }
    return false;
  } // END-setActualizarPago
    
  
  public function setActivar(int $estudiante_id): bool {
    $RegEstud = (new Estudiante)->get((int)$estudiante_id);
    if ($RegEstud) {
      $RegEstud->is_active = 1;
      $RegEstud->save();
      return true;
    }
    return false;
  } // END-setActivar
  
  

}