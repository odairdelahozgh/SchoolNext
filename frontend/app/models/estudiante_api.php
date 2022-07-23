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
class EstudianteApi extends LiteRecord
{
  protected static $table = 'sweb_estudiantes'; 
  const IS_ACTIVE = [
    0 => 'Inactivo',
    1 => 'Activo'
  ];
  
  //=============
  public function before_delete() {
    if($this->is_active==1) {
      // ?? Flash::warning('No se puede borrar un registro activo');
      return 'cancel';
    }
  } // END-

  //=============
  public function after_delete() { 
    // ?? Flash::valid('Se borró el registro'); 
  } // END-
  
  //=============
  public function before_create() { 
    $this->is_active = 1; 
  } // END-

  
  //==============
  private function getList() {
    return "SELECT e.*, s.nombre as salon
            FROM ".self::$table." as e
            LEFT JOIN ".Config::get('tablas.salon')." as s ON e.salon_id=s.id";
  } // END-

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

  //=============
  public function getListActivos($orden='a1, a2, n') {
    $orden = str_replace(
      array('n', 'a1', 'a2'),
      array('e.nombres', 'e.apellido1', 'e.apellido2'),
      $orden
    );
    $DQL = $this->getList($orden)
          ." WHERE e.is_active=1 "
          ." ORDER BY $orden";
    return $this->data = $this::all($DQL);
  } // END-

  //=============
  public function getListInactivos($orden='a1, a2, n') {
    $orden = str_replace(
      array('n', 'a1', 'a2'),
      array('e.nombres', 'e.apellido1', 'e.apellido2'),
      $orden
    );
    $DQL = $this->getList($orden)
          ." WHERE e.is_active=0 "
          ." ORDER BY $orden";
    return $this->data = $this::all($DQL);
  } // END-getListInactivos


}