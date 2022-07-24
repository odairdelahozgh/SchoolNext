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
  protected static $table = 'sweb_estudiantes';

  protected static $_defaults = array();
  protected static $_labels = array();
  protected static $_placeholders = array();
  protected static $_helps = array();
  public function getDefault($field) { return ((array_key_exists($field, self::$_defaults)) ? self::$_defaults[$field] : null); }
  public function getLabel($field) { return ((array_key_exists($field, self::$_labels)) ? self::$_labels[$field] : $field.': '); }
  public function getPlaceholder($field) { return ((array_key_exists($field, self::$_placeholders)) ? self::$_placeholders[$field] : ''); }
  public function getHelp($field) { return ((array_key_exists($field, self::$_placeholders)) ? self::$_helps[$field]: ''); }
  
  
  public function __toString() { return $this->getNombreCompleto(); }

  const IS_ACTIVE = [
    0 => 'Inactivo',
    1 => 'Activo'
  ];

  //=============
  public function getCodigo() {
    return '[Cod: '.$this->id.']';
  } // END-getApellidos
  
  //=============
  public function getApellidos() {
    return $this->apellido1.' '.$this->apellido2;
  } // END-getApellidos

  //=============
  public function getNombreCompleto($orden='a1 a2, n') {
    return str_replace(
          array('n', 'a1', 'a2'),
          array($this->nombres, $this->apellido1, $this->apellido2),
          $orden
      );
  } // END-getNombreCompleto

  //=============
  public function getIsActiveF() {
    return (($this->is_active) ? _Icons::solid('face-smile', 'w3-small') : _Icons::solid('face-frown', 'w3-small') );
  } // END-getIsActiveF

  
  //=========
  public function isPazYSalvo() {
    $periodo = Config::get('academico.periodo_actual');
    if ($periodo==1 and $this->mes_pagado>=4) { return true; }
    if ($periodo==2 and $this->mes_pagado>=6) { return true; }
    if ($periodo==3 and $this->mes_pagado>=8) { return true; }
    if ($periodo==4 and $this->mes_pagado>=11 and !$this->is_debe_preicfes and !$this->is_debe_almuerzos) { return true; }
    if ($periodo==5 and $this->mes_pagado>=11 and !$this->is_debe_preicfes and !$this->is_debe_almuerzos) { return true; }
    return false;
  } // END-isPazYSalvo

  //=========
  public function isPazYSalvoIco() {
    return ($this->isPazYSalvo()) ? _Icons::solid('face-smile', 'w3-small') : _Icons::solid('face-frown', 'w3-small') ; ;
  } // END-isPazYSalvo


  //=============
  public function getCuentaInstit(){
    return ($this->email_instit) ? $this->email_instit.'@'.Config::get('institucion.dominio').' '.$this->clave_instit : '';

  } // END-getCuentaInstit

  //=============
  public function getFoto($max_width=80) {
    return _Tag::img("upload/estudiantes/$this->id.png",$this->id,
               "class=\"w3-round\" style=\"width:100%;max-width:$max_width px\"", 'sin foto');
  } // END-getFoto

  //=============
  public function getFotoCircle($max_width=80) {
    return _Tag::img("upload/estudiantes/$this->id.png",$this->id,
               "class=\"w3-circle w3-bar-item\" style=\"width:100%;max-width:$max_width px\"", 'sin foto');
  } // END-getFotoCircle


  //public $before_delete = 'no_borrar_activos';
  //=============
  public function no_borrar_activos() {
    if($this->is_active==1) {
      OdaFlash::warning('No se puede borrar un registro activo');
      return 'cancel';
    }
  } // END-

  //=============
  public function after_delete() { 
    OdaFlash::valid('Se borró el registro'); 
  } // END-

  //=============
  public function before_create() { 
    $this->is_active = 1; 
  } // END-

  
  //==============
  public function getList($estado=null, $orden='a1,a2,n') {
    $orden = str_replace(
      array('n', 'a1', 'a2'),
      array('e.nombres', 'e.apellido1', 'e.apellido2'),
      $orden
    );

    $nombre_estud = "CONCAT(a1, ' ', a2, ' ', n) AS estud";
    $nombre_estud = str_replace(
      array('n', 'a1', 'a2'),
      array('e.nombres', 'e.apellido1', 'e.apellido2'),
      $nombre_estud
    );

    if (is_null($estado)) { // todos
      $DQL = "SELECT e.*, $nombre_estud, s.nombre AS salon
      FROM ".self::$table." AS e
      LEFT JOIN ".Config::get('tablas.salon')." AS s ON e.salon_id=s.id
      ORDER BY $orden";
      return $this::all($DQL);
    } else {
      $DQL = "SELECT e.*, $nombre_estud, s.nombre AS salon
      FROM ".self::$table." AS e
      LEFT JOIN ".Config::get('tablas.salon')." AS s ON e.salon_id=s.id
      WHERE e.is_active=?
      ORDER BY $orden";
      
      return $this::all($DQL, array((int)$estado));
    }

  } // END-getList
  

  //==============
  public function getListActivos($orden='a1,a2,n') {
    $orden = str_replace(
      array('n', 'a1', 'a2'),
      array('e.nombres', 'e.apellido1', 'e.apellido2'),
      $orden
    );

    $nombre_estud = "CONCAT(a1, ' ', a2, ' ', n) AS estud";
    $nombre_estud = str_replace(
      array('n', 'a1', 'a2'),
      array('e.nombres', 'e.apellido1', 'e.apellido2'),
      $nombre_estud
    );
    
    $DQL = "SELECT e.*, $nombre_estud, s.nombre AS salon
      FROM ".self::$table." AS e
      LEFT JOIN ".Config::get('tablas.salon')." AS s ON e.salon_id=s.id
      WHERE e.is_active=1
      ORDER BY $orden";
    
    return $this::all($DQL);
  } // END-getList
  
  
  //==============
  public function getListInactivos($orden='a1,a2,n') {
    $orden = str_replace(
      array('n', 'a1', 'a2'),
      array('e.nombres', 'e.apellido1', 'e.apellido2'),
      $orden
    );

    $nombre_estud = "CONCAT(a1, ' ', a2, ' ', n) AS estud";
    $nombre_estud = str_replace(
      array('n', 'a1', 'a2'),
      array('e.nombres', 'e.apellido1', 'e.apellido2'),
      $nombre_estud
    );
    
    $DQL = "SELECT e.*, $nombre_estud, s.nombre AS salon
      FROM ".self::$table." AS e
      LEFT JOIN ".Config::get('tablas.salon')." AS s ON e.salon_id=s.id
      WHERE e.is_active=0
      ORDER BY $orden";
    
    return $this::all($DQL);
  } // END-getList
  

  //=============
  public function getListPorProfesor($user_id) {
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
    public function getSalonesCambiar($modulo) {
      $lnk_cambio = '';
      if ($this->is_active) {
          $salonesSig = array(
              0 => array(),
              1 => array(1=>'01-A',2=>'01-B',23=>'01-C',  3=>'02-A',4=>'02-B',29=>'02-C'),
              2 => array(3=>'02-A',4=>'02-B',29=>'02-C',  5=>'03-A',6=>'03-B',30=>'03-C'),
              3 => array(5=>'03-A',6=>'03-B',30=>'03-C',  7=>'04-A',24=>'04-B',32=>'04-C'),
              4 => array(7=>'04-A',24=>'04-B',32=>'04-C', 8=>'05-A',26=>'05-B',33=>'05-C'),
              5 => array(8=>'05-A',26=>'05-B',33=>'05-C', 21=>'06-A',25=>'06-B'),
              6 => array(21=>'06-A',25=>'06-B', 20=>'07-A',28=>'07-B'),
              7 => array(20=>'07-A',28=>'07-B', 19=>'08-A',31=>'08-B'),
              8 => array(19=>'08-A',31=>'08-B', 18=>'09-A',34=>'09-B'),
              9 => array(18=>'09-A',34=>'09-B', 17=>'10-A',35=>'10-B'),
              10 => array(17=>'10-A',35=>'10-B', 16=>'11-A',36=>'11-B'),
              11 => array(16=>
              '11-A',36=>'11-B'),
              12 => array(15=>'PV-A', 10=>'PK-A',11=>'PK-B'),
              13 => array(10=>'PK-A',11=>'PK-B', 12=>'KD-A',13=>'KD-B',22=>'KD-C'),
              14 => array(12=>'KD-A',13=>'KD-B',22=>'KD-C', 9=>'TN-A',14=>'TN-B'),
              15 => array(9=>'TN-A',14=>'TN-B', 1=>'01-A',2=>'01-B',23=>'01-C'),
          );
          foreach ($salonesSig[$this->grado_mat] as $key_salon => $salon_nombre) {
              $lnk_cambio .= Html::link("$modulo/cambiar_salon_estudiante/$this->id/$key_salon/", $salon_nombre, 'class="btn btn-success btn-sm"').'  ';
          }
      }
      return $lnk_cambio;
  }

  public function setCambiarSalon($salon_id, $cambiar_en_notas=false) {
      $salon = (new Salon)->get((int) $salon_id);
      if ($salon) {
          // Cambia el salón en la tabla de ESTUDIANTES
          $this->salon_id  = $salon->id;
          $this->grado_mat = $salon->grado_id;
          $this->update();
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
  
  
  public function setActualizarPago($estudiante_id) {
    $Estud = (new Estudiante)->get((int)$estudiante_id);
    $Estud->mes_pagado = 6;
    $Estud->save();
    return true;
  } // END-setActualizarPago
    
  
  public function setActivar($estudiante_id) {
    $Estud = (new Estudiante)->get((int)$estudiante_id);
    $Estud->is_active = 1;
    $Estud->save();
    
  } // END-setActivar
  
  

}