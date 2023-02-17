<?php

use PhpParser\Node\Stmt\TryCatch;

/**
 * Modelo Estudiante 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

 /*
  // crear registro:               ->create(array $data = []): bool {}
  // actualizar registro:          ->update(array $data = []): bool {}
  // Guardar registro:             ->save(array $data = []): bool {}
  // Eliminar registro por pk:     ::delete($pk): bool
  //
  // Buscar por clave pk:                 ::get($pk, $fields = '*') $fields: campos separados por coma
  // Todos los registros:                 ::all(string $sql = '', array $values = []): array {}
  // Primer registro de la consulta sql:  ::first(string $sql, array $values = [])//: static in php 8
  // Filtra las consultas                 ::filter(string $sql, array $values = []): array
*/

class Estudiante extends LiteRecord
{
  use TraitUuid, EstudianteTraitCallBacks, EstudianteTraitDefa, EstudianteTraitProps, 
      EstudianteTraitLinksOlds, EstudianteTraitCorrecciones;

  // OdaLog::debug(msg: "Mensaje", name_log:'nombre_log'); // debug, warning, error, alert, critical, notice, info, emergence
  
  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.estudiantes');
    self::$_defaults     = $this->getTDefaults();
    self::$_labels       = $this->getTLabels();
    self::$_placeholders = $this->getTPlaceholders();
    self::$_helps        = $this->getTHelps();
    self::$_attribs      = $this->getTAttribs();
    self::$default_foto_estud        = '<img src="/img/upload/estudiantes/user.png" alt="" class="w3-round" style="width:100%;max-width:80 px">';
    self::$default_foto_estud_circle = '<img src="/img/upload/estudiantes/user.png" alt="" class="w3-circle w3-bar-item" style="width:100%;max-width:80 px">';
    self::$class_name = __CLASS__;
    self::$order_by_default = 't.apellido1, t.apellido1, t.nombres';
  }

  const LIM_PAGO_PERIODOS = [ 1 => 4, 2 => 6, 3 => 9, 4 => 11, 5 => 11 ];
  
   
  /**
   * Devuelve lista de todos los Registros.
   */
  public function getListEstudiantes(string $orden='a1,a2,n', int|bool $estado=null, string|bool $order_by=null) {
/*     $orden = str_replace(
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

    $salon = (self::$session_username=='admin') ? " CONCAT('[',s.id,'] ',s.nombre) AS salon_nombre " : " s.nombre AS salon_nombre " ;
    $grado = (self::$session_username=='admin') ? " CONCAT('[',g.id,'] ',g.nombre) AS grado_nombre " : " g.nombre  AS grado_nombre " ;
    
    $DQL = (new OdaDql(__CLASS__))
        ->select('t.*, g.grado_id, '.$nombre_estud.' as estudiante_nombre, de.*')
        ->addSelect("$salon, $grado")
        ->leftJoin('datosestud', 'de')
        ->leftJoin('salon', 's')
        ->leftJoin('grado', 'g', 's.grado_id')
        ->orderBy(self::$order_by_default);
        
    if (!is_null($order_by)) { $DQL->orderBy($order_by); }
    if (!is_null($estado))   { $DQL->where('t.is_active=?')->setParams([$estado]); }
     */
    // NO EJECUTAR AHORA !!!!
    //return $DQL->execute();

    // OTRA OPCIÓN

    

    $sql = "SELECT t.*, g.id as grado_id,
    de.madre, de.madre_id, de.madre_tel_1, de.madre_email, de.padre, de.padre_id, de.padre_tel_1, de.padre_email, 
    CONCAT(t.apellido1, ' ', t.apellido2, ' ', t.nombres) as estudiante_nombre, 
    CONCAT('[',s.id,'] ',s.nombre) AS salon_nombre,  
    CONCAT('[',g.id,'] ',g.nombre) AS grado_nombre  
    
    FROM sweb_estudiantes AS t 
    LEFT JOIN sweb_datosestud AS de ON t.id = de.estudiante_id   
    LEFT JOIN sweb_salones    AS s  ON t.salon_id = s.id   
    LEFT JOIN sweb_grados     AS g  ON s.grado_id = g.id 
    
    WHERE t.is_active=?  ORDER BY t.apellido1, t.apellido1, t.nombres";
    return $this::all($sql, [(int)$estado]);
    
  } // END-getList

  
  /*
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
      LEFT JOIN ".Config::get('tablas.salones')." AS s ON e.salon_id=s.id
      LEFT JOIN ".Config::get('tablas.grados')." AS g ON e.grado_mat=g.id
      ORDER BY $orden";
      return $this::all($DQL);
    } else {
      $DQL = "SELECT e.*, $nombre_estud AS nombre_estudiante, $salon, $grado
      FROM ".self::$table." AS e
      LEFT JOIN ".Config::get('tablas.salones')." AS s ON e.salon_id=s.id
      LEFT JOIN ".Config::get('tablas.grados')." AS g ON e.grado_mat=g.id
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
      LEFT JOIN ".Config::get('tablas.salones')." AS s ON e.salon_id=s.id
      LEFT JOIN ".Config::get('tablas.grados')." AS g ON e.grado_mat=g.id
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
      LEFT JOIN ".Config::get('tablas.grados')." AS g ON e.grado_mat=g.id
      WHERE e.is_active=0
      ORDER BY $orden";
    
    return $this::all($DQL);
  } // END-getList
  
   
   */

  /**
   * 
   */
  public function getListPorProfesor(int $user_id): array {
    $salones = '';
    $CargaProfe = (new CargaProfesor)->getSalonesCarga($user_id);
    foreach ($CargaProfe as $key => $carga) {
      $salones .= $carga->salon_id.",";
    }
    $salones = substr($salones,0,-1);
    $DQL = "SELECT e.*, s.nombre as salon
            FROM ".self::$table." as e
            LEFT JOIN ".Config::get('tablas.salones')." as s ON e.salon_id=s.id
            WHERE s.id IN($salones)";
    return $this->data = $this::all($DQL);
  } // END-

  
    /**
     * 
     */
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

  /**
   * CAMBIA DE SALÓN UN ESTUDIANTE
   */
  public function setCambiarSalon(int $salon_id, bool $cambiar_en_notas=true): bool {
    try {
      $estud_id = $this->id;
      $RegSalon = (new Salon)->get($salon_id);

      if ($RegSalon) {
          // Cambia el salón en la tabla de ESTUDIANTES
          $this->salon_id  = $RegSalon->id;
          $this->grado_mat = $RegSalon->grado_id;
          $this->save();
          // Lo debe cambiar de salón en la tabla NOTAS también.
          //OdaLog::debug("RegNotaEstud: $cnt", 'setCambiarSalon');
          
          if ($cambiar_en_notas) {

            $RegNotaEstud = (new Nota)->Filter("WHERE estudiante_id=?", [$estud_id]);
            $RegRegistrosGenEstud = (new RegistrosGen)->Filter("WHERE estudiante_id=?", [$estud_id]);
            $RegRegistrosDesempEstud = (new RegistrosDesemp)->Filter("WHERE estudiante_id=?", [$estud_id]);
            
            $cnt = 0;
            foreach ($RegNotaEstud as $nota) {
              $nota->salon_id = $RegSalon->id;
              $nota->grado_id = $RegSalon->grado_id;
              $nota->save();
              $cnt += 1;
            }
            //OdaLog::debug(msg: "Mensaje", name_log:'nombre_log'); // custom, debug, warning, error, alert, critical, notice, info, emergence
            
            $cnt = 0;
            foreach ($RegRegistrosGenEstud as $regGen) {
              $regGen->salon_id = $RegSalon->id;
              $regGen->grado_id = $RegSalon->grado_id;
              $regGen->save();
              $cnt += 1;
            }
            //OdaLog::debug("RegRegistrosGenEstud: $cnt", 'setCambiarSalon');

            $cnt = 0;
            foreach ($RegRegistrosDesempEstud as $regDesemp) {
              $regDesemp->salon_id = $RegSalon->id;
              $regDesemp->grado_id = $RegSalon->grado_id;
              $regDesemp->save();
              $cnt += 1;
            }
            //OdaLog::debug("RegRegistrosDesempEstud: $cnt", 'setCambiarSalon');

          }
          return true;
      }
      return false;

      
    } catch (\Throwable $th) {
      OdaLog::error($th);
    }
  }
  
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
 


}//END-Estudiante