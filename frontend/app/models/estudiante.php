<?php
/**
 * Modelo Estudiante 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * 'id', 'is_active', 'mes_pagado', 'is_debe_preicfes', 'is_debe_almuerzos', 'is_deudor', 'is_habilitar_mat', 
 * 'salon_id', 'grado_mat', 'numero_mat', 'annio_promovido', 'uuid', 'documento', 'contabilidad_id', 
 * 'nombres', 'apellido1', 'apellido2', 'fecha_nac', 'direccion', 'barrio', 'telefono1', 'telefono2', 'email', 
 * 'created_at', 'updated_at', 'created_by', 'updated_by', 'tipo_dcto', 'sexo', 'photo', 'ape1ape1', 'retiro', 'fecha_ret', 
 * 'mat_bajo_p1', 'mat_bajo_p2', 'mat_bajo_p3', 'mat_bajo_p4', 'email_instit', 'clave_instit', 'annio_pagado'
 */
  
class Estudiante extends LiteRecord {

  use EstudianteTraitSetUp;

  private mixed $DQL = null;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.estudiante');
    self::$_order_by_defa = 'g.orden,s.nombre,t.apellido1,t.apellido2,t.nombres';

    $this->DQL = (new OdaDql(__CLASS__))
      ->select('t.*, s.nombre AS salon_nombre, s.grado_id, g.nombre AS grado_nombre')
      ->leftJoin('datosestud', 'de', 't.id=de.estudiante_id')
      ->leftJoin('salon', 's')
      ->leftJoin('grado', 'g', 's.grado_id=g.id')
      //->where('t.salon_id<>0 AND t.is_active=1')
      ->where('t.is_active=1')
      ->orderBy(self::$_order_by_defa);

    $this->setUp();
  } //END-__construct

  
  public function getList(int|bool $estado=null, string $select='*', string|bool $order_by=null) {
    try {
      $DQL = $this->DQL;
      $DQL->concat(['t.apellido2', 't.apellido1', 't.nombres'], 'estudiante_nombre')
          ->concat(['t.apellido2', 't.apellido1', 't.nombres'], 'nombre');
      if (!is_null($order_by)) { $DQL->orderBy($order_by); }
      if (!is_null($estado))   { $DQL->where('t.salon_id<>0 AND t.is_active=?')->setParams([$estado]); }
      return $DQL->execute();
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } // END-getList

  
  public function getListBySalon(string $orden='a1,a2,n', string $select='*') {
    try {
      $DQL = $this->DQL;
      $orden = str_replace(array('n', 'a1', 'a2'), array('t.nombres', 't.apellido1', 't.apellido2'), $orden );
      $DQL->concat(explode(',', $orden), 'estudiante_nombre')
          ->concat(explode(',', $orden), 'nombre')
          ->andWhere('');

      return $DQL->execute();
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } // END-getList

  
  public function getListEstudiantes(string $orden='a1,a2,n', int|bool $estado=null, string|bool $order_by=null) {
    try {
      $DQL = $this->DQL;
      $orden = str_replace(array('n', 'a1', 'a2'), array('t.nombres', 't.apellido1', 't.apellido2'), $orden );
      $DQL->concat(explode(',', $orden), 'estudiante_nombre')
          ->concat(explode(',', $orden), 'nombre');
      if (!is_null($order_by)) { $DQL->orderBy($order_by); }
      if (!is_null($estado))   { $DQL->where('t.salon_id<>0 AND t.is_active=?')->setParams([$estado]); }
      return $DQL->execute();

    } catch (\Throwable $th) {
      //throw $th;
        OdaFlash::error($th);
    }
  } // END-getListEstudiantes.

  //proyecto para reemplazar varios list, dependiendo del módulo desde donde se hace la llamada.
  /**
   * 'id', 'is_active', 'mes_pagado', 'is_debe_preicfes', 'is_debe_almuerzos', 'is_deudor', 'is_habilitar_mat', 
  * 'salon_id', 'grado_mat', 'numero_mat', 'annio_promovido', 'uuid', 'documento', 'contabilidad_id', 
  * 'nombres', 'apellido1', 'apellido2', 'fecha_nac', 'direccion', 'barrio', 'telefono1', 'telefono2', 'email', 
  * 'created_at', 'updated_at', 'created_by', 'updated_by', 'tipo_dcto', 'sexo', 'photo', 'ape1ape1', 'retiro', 'fecha_ret', 
  * 'mat_bajo_p1', 'mat_bajo_p2', 'mat_bajo_p3', 'mat_bajo_p4', 'email_instit', 'clave_instit', 'annio_pagado'
  * 
  */
  public function getListActivosByModulo(Modulo $modulo = Modulo::Docen, string $orden='a1,a2,n', array|string $where = null) {
    try {
      
      $orden = str_replace(array('n', 'a1', 'a2'), array('t.nombres', 't.apellido1', 't.apellido2'), $orden );

      $DQL = (new OdaDql(__CLASS__))
        ->select('t.id, t.is_active, t.uuid, t.documento, t.salon_id')
        ->concat(explode(',', $orden), 'estudiante_nombre')
        ->concat(explode(',', $orden), 'nombre')
        ->addSelect('s.nombre AS salon_nombre, s.grado_id, g.nombre AS grado_nombre')

        ->leftJoin('datosestud', 'de', 't.id=de.estudiante_id')
        ->leftJoin('salon', 's')
        ->leftJoin('grado', 'g', 's.grado_id=g.id')
        ->where('t.is_active=1')
        ->orderBy(self::$_order_by_defa);
      
      if ( (Modulo::Psico == $modulo) or (Modulo::Secre == $modulo) or (Modulo::Conta == $modulo) or (Modulo::Enfer == $modulo) ) {
        $DQL->addSelect('de.madre, de.madre_id, de.madre_tel_1, de.madre_email')
            ->addSelect('de.padre, de.padre_id, de.padre_tel_1, de.padre_email');
      }
      
      if (Modulo::Conta == $modulo) {
        $DQL->addSelect('de.deudor, de.codeudor, de.codeudor_cc, de.resp_pago_ante_dian');
      }

      if (!is_null($where)) {
        if (is_array($where)) {
          $a_keys = array_keys($where);
          $a_values = array_values($where);
          $filtro = '';
          foreach ($a_keys as $key => $value) {
            $prefijo = (str_starts_with($value, 't.')) ? '' : 't.' ;
            $filtro .= (0==$key) ? "{$prefijo}{$value}=?" : ", {$prefijo}{$value}=?";
          }
          $DQL->andWhere($filtro)
              ->setParams($a_values);
        } else {
          $prefijo = (str_starts_with($where, 't.')) ? '' : 't.' ;
          $filtro  = "{$prefijo}{$where}=?";
          $DQL->andWhere($filtro); // el where viene listo
        } 
      }

      return $DQL->execute(true);
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } // END-getListActivosByModulo


  public function getListSecretaria(string $orden='a1,a2,n', int|bool $estado=null, string|bool $order_by=null) {
    try {
      $DQL = $this->DQL;
      $orden = str_replace(array('n', 'a1', 'a2'), array('t.nombres', 't.apellido1', 't.apellido2'), $orden );
      $DQL->concat(explode(',', $orden), 'estudiante_nombre')
          ->concat(explode(',', $orden), 'nombre')
          ->addSelect('de.madre, de.madre_id, de.madre_tel_1, de.madre_email, de.padre, de.padre_id, de.padre_tel_1, de.padre_email');
      if (!is_null($order_by)) { $DQL->orderBy($order_by); }
      if (!is_null($estado))   { $DQL->where('t.salon_id<>0 AND t.is_active=?')->setParams([$estado]); }
      return $DQL->execute();

    } catch (\Throwable $th) {
      throw $th;
    }
  } // END-getListSecretaria


  public function getListContabilidad(string $orden='a1,a2,n') {
    try {
      $DQL = $this->DQL;
      $orden = str_replace(array('n', 'a1', 'a2'), array('t.nombres', 't.apellido1', 't.apellido2'), $orden );
      $DQL->concat(explode(',', $orden), 'estudiante_nombre')
          ->concat(explode(',', $orden), 'nombre')
          ->addSelect('de.madre, de.madre_id, de.madre_tel_1, de.madre_email, de.padre, de.padre_id, de.padre_tel_1, de.padre_email')
          ->addSelect('de.deudor, de.codeudor, de.codeudor_cc, de.resp_pago_ante_dian');
      return $DQL->execute();
      
    } catch (\Throwable $th) {
        OdaFlash::error($th);
    }
  } // END-getListContabilidad


  public function getListSicologia(string $orden='a1,a2,n') {
    try {
      $DQL = $this->DQL;
      $orden = str_replace(array('n', 'a1', 'a2'), array('t.nombres', 't.apellido1', 't.apellido2'), $orden );
      $DQL->concat(explode(',', $orden), 'estudiante_nombre')
          ->concat(explode(',', $orden), 'nombre')
          ->addSelect('de.madre, de.madre_id, de.madre_tel_1, de.madre_email, de.padre, de.padre_id, de.padre_tel_1, de.padre_email')
          ->orderBy('g.orden,s.nombre,'.$orden);
      return $DQL->execute();

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } // END-getListSicologia



  public function getListEnfermeria(string $orden='a1,a2,n') {
    try {
      $DQL = $this->DQL;
      $orden = str_replace(array('n', 'a1', 'a2'), array('t.nombres', 't.apellido1', 't.apellido2'), $orden );
      $DQL->concat(explode(',', $orden), 'estudiante_nombre')
          ->concat(explode(',', $orden), 'nombre')
          ->addSelect('de.madre, de.madre_id, de.madre_tel_1, de.madre_email, de.padre, de.padre_id, de.padre_tel_1, de.padre_email')
          ->orderBy('g.orden,s.nombre,'.$orden);
      return $DQL->execute();

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } // END-getListEnfermeria


  public function getListPadres(int $user_id, string $orden='a1,a2,n'): array|string {
    try {
      $lista = (new EstudiantePadres)->getHijos($user_id);
      $filtro = implode(',', $lista);

      $orden = str_replace(array('n', 'a1', 'a2'), array('t.nombres', 't.apellido1', 't.apellido2'), $orden );
      $DQL = $this->DQL;
      $DQL->concat(explode(',', $orden), 'estudiante_nombre')
          ->concat(explode(',', $orden), 'nombre')
          ->andWhere("t.id IN ($filtro)")
          ->orderBy('g.orden,s.nombre,'.$orden);

      return $DQL->execute();

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } // END-getListPadres

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
      $RegSalonNew = (new Salon)::get($nuevo_salon_id);
      if ($RegSalonNew) {
          $RegEstud = (new Estudiante)::get($estudiante_id);
          $RegEstud->salon_id  = $RegSalonNew->id;
          $RegEstud->grado_mat = $RegSalonNew->grado_id;
          $RegEstud->save();
          if ($cambiar_en_notas) {
            (new Nota)->cambiarSalonEstudiante($nuevo_salon_id, $RegSalonNew->grado_id, $estudiante_id);
            (new RegistrosGen)->cambiarSalonEstudiante($nuevo_salon_id, $RegSalonNew->grado_id, $estudiante_id);
            (new RegistroDesempAcad)->cambiarSalonEstudiante($nuevo_salon_id, $RegSalonNew->grado_id, $estudiante_id);
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
    try {
      $RegEstud = (new Estudiante)->get($estudiante_id);
      if ($RegEstud) {
        $RegEstud->mes_pagado = self::LIM_PAGO_PERIODOS[self::$_periodo_actual];
        $RegEstud->annio_pagado = self::$_annio_actual;
        $RegEstud->save();
        return true;
      }
      return false;
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } // END-setActualizarPago 
  

  public function setMesPago(int $estudiante_id, int $mes): bool {
    try {
      $RegEstud = (new Estudiante)->get($estudiante_id);
      if ($RegEstud) {
        $RegEstud->mes_pagado = $mes;
        $RegEstud->annio_pagado = self::$_annio_actual;
        $RegEstud->save();
        return true;
      }
      return false;
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } // END-setMesPago 
 
}//END-CLASS