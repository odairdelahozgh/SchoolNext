<?php
/**
 * Modelo 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 */
 
include "estudiante/estudiante_trait_correcciones.php";
include "estudiante/estudiante_trait_datos_padres.php";
include "estudiante/estudiante_trait_links.php";
include "estudiante/estudiante_trait_matriculas.php";
include "estudiante/estudiante_trait_props.php";
include "estudiante/estudiante_trait_setters.php";
include "estudiante/estudiante_trait_set_up.php";

class Estudiante extends LiteRecord 
{

  use EstudianteTraitSetUp;

  private mixed $DQL = null;

  public function __construct() 
  {
    parent::__construct();
    self::$table = Config::get('tablas.estudiante');
    self::$_order_by_defa = 'g.orden,s.nombre,t.apellido1,t.apellido2,t.nombres';
    $this->DQL = (new OdaDql(__CLASS__))
      ->select('t.*, s.nombre AS salon_nombre, s.grado_id, g.nombre AS grado_nombre')
      ->leftJoin('datosestud', 'de', 't.id=de.estudiante_id')
      ->leftJoin('salon', 's')
      ->leftJoin('grado', 'g', 's.grado_id=g.id')
      ->where('t.is_active=1')
      ->orderBy(self::$_order_by_defa);      
    $this->setUp();
  }

  
  public function getList(
    int|bool $estado=null, 
    string $select='*', 
    string|bool $order_by=null
  ): array|string 
  {
    $DQL = $this->DQL;
    $DQL->concat(['t.apellido1', 't.apellido2', 't.nombres'], 'estudiante_nombre')
        ->concat(['t.apellido1', 't.apellido2', 't.nombres'], 'nombre');        
    if (!is_null(self::$_order_by_defa))
    {
      $DQL->orderBy(self::$_order_by_defa); 
    }
    if (!is_null($estado))
    {
      $DQL->where('t.salon_id<>0 AND t.is_active=?')->setParams([$estado]);
    }
    return $DQL->execute();
  }

  
  public function getListBySalon(
    int $salon_id, 
    string $select='t.*',
    string $orden='a1,a2,n', 
  ): array|string 
  {    
    $orden = str_replace(
      array('n', 'a1', 'a2'), 
      array('t.nombres', 't.apellido1', 't.apellido2'), 
      $orden
    );
    $DQL = new OdaDql(__CLASS__);
    $DQL->select($select)
        ->addSelect('s.nombre AS salon_nombre, s.grado_id, g.nombre AS grado_nombre')
        ->concat(explode(',', $orden), 'estudiante_nombre')
        ->concat(explode(',', $orden), 'nombre')
        ->leftJoin('datosestud', 'de', 't.id=de.estudiante_id')
        ->leftJoin('salon', 's')
        ->leftJoin('grado', 'g', 's.grado_id=g.id')
        ->where('t.is_active=1')
        ->andWhere('t.salon_id=?')
        ->setParams([$salon_id])
        ->orderBy(self::$_order_by_defa);
    return $DQL->execute();
  }

  
  public function getListEstudiantes(
    string $select='t.*',
    string $orden='a1,a2,n', 
    int|bool $estado=null, 
    string|bool $order_by=null
  ): array|string 
  {
    $orden = str_replace(
      array('n', 'a1', 'a2'), 
      array('t.nombres', 't.apellido1', 't.apellido2'), 
      $orden
    );
    $DQL = (new OdaDql(__CLASS__))
      ->select($select)
      ->addSelect('s.nombre AS salon_nombre, s.grado_id, g.nombre AS grado_nombre')
      ->concat(explode(',', $orden), 'estudiante_nombre')
      ->concat(explode(',', $orden), 'nombre')
      ->leftJoin('datosestud', 'de', 't.id=de.estudiante_id')
      ->leftJoin('salon', 's')
      ->leftJoin('grado', 'g', 's.grado_id=g.id')
      ->where('t.is_active=1')
      ->orderBy(self::$_order_by_defa);    
    if (!is_null($order_by))
    {
      $DQL->orderBy($order_by); 
    }
    if (!is_null($estado))
    {
      if($estado)
      {
        $DQL->where('t.salon_id<>0 AND t.is_active=1');
      }
      else
      {
        $DQL->where('t.is_active=0');
      }
    }
    return $DQL->execute();
  }


  //proyecto para reemplazar varios list, dependiendo del módulo desde donde se hace la llamada.
  public function getListActivosByModulo(
    Modulo $modulo = Modulo::Docen, 
    string $orden='a1,a2,n', 
    array|string $where = null
  ): array|string 
  {
    $orden = str_replace(
      array('n', 'a1', 'a2'), 
      array('t.nombres', 't.apellido1', 't.apellido2'), 
      $orden
    );
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
    if ( (Modulo::Psico == $modulo) or (Modulo::Secre == $modulo) 
        or (Modulo::Conta == $modulo) or (Modulo::Enfer == $modulo) )
    {
      $DQL->addSelect('de.madre, de.madre_id, de.madre_tel_1, de.madre_email')
          ->addSelect('de.padre, de.padre_id, de.padre_tel_1, de.padre_email');
    }
    if (Modulo::Conta == $modulo)
    {
      $DQL->addSelect('de.deudor, de.codeudor, de.codeudor_cc, de.resp_pago_ante_dian');
    }
    if (!is_null($where))
    {
      if (is_array($where))
      {
        $a_keys = array_keys($where);
        $a_values = array_values($where);
        $filtro = '';
        foreach ($a_keys as $key => $value)
        {
          $prefijo = (str_starts_with($value, 't.')) ? '' : 't.' ;
          $filtro .= (0==$key) ? "{$prefijo}{$value}=?" : ", {$prefijo}{$value}=?";
        }
        $DQL->andWhere($filtro)
            ->setParams($a_values);
      }
      else
      {
        $prefijo = (str_starts_with($where, 't.')) ? '' : 't.' ;
        $filtro  = "{$prefijo}{$where}=?";
        $DQL->andWhere($filtro); // el where viene listo
      } 
    }
    return $DQL->execute();
  }
  

  public function getListSecretaria(
    string $orden='a1,a2,n', 
    int|bool $estado=null, 
    string|bool $order_by=null
  ): array|string 
  {
    $DQL = $this->DQL;
    $orden = str_replace(
      array('n', 'a1', 'a2'), 
      array('t.nombres', 't.apellido1', 't.apellido2'), 
      $orden
    );
    $DQL->concat(explode(',', $orden), 'estudiante_nombre')
          ->concat(explode(',', $orden), 'nombre')
          ->addSelect('de.madre, de.madre_id, de.madre_tel_1, de.madre_email, de.padre, de.padre_id, de.padre_tel_1, de.padre_email');
    if (!is_null($order_by))
    {
      $DQL->orderBy($order_by); 
    }
    if (!is_null($estado))
    {
        $DQL->where('t.is_active=?')->setParams([$estado]); 
    }
    return $DQL->execute();
  }


  public function getListContabilidad(string $orden='a1,a2,n'): array|string 
  {
    $DQL = $this->DQL;
    $orden = str_replace(
      array('n', 'a1', 'a2'), 
      array('t.nombres', 't.apellido1', 't.apellido2'), 
      $orden
    );
    $DQL->concat(explode(',', $orden), 'estudiante_nombre')
        ->concat(explode(',', $orden), 'nombre')
        ->addSelect('de.madre, de.madre_id, de.madre_tel_1, de.madre_email, de.padre, de.padre_id, de.padre_tel_1, de.padre_email')
        ->addSelect('de.deudor, de.codeudor, de.codeudor_cc, de.resp_pago_ante_dian');
    return $DQL->execute();
  }


  public function getListSicologia(string $orden='a1,a2,n'): array|string 
  {
    $DQL = $this->DQL;
    $orden = str_replace(
      array('n', 'a1', 'a2'), 
      array('t.nombres', 't.apellido1', 't.apellido2'), 
      $orden
    );
    $DQL->concat(explode(',', $orden), 'estudiante_nombre')
        ->concat(explode(',', $orden), 'nombre')
        ->addSelect('de.madre, de.madre_id, de.madre_tel_1, de.madre_email, de.padre, de.padre_id, de.padre_tel_1, de.padre_email')
        ->orderBy('g.orden,s.nombre,'.$orden);
    return $DQL->execute();
  }


  public function getListEnfermeria(string $orden='a1,a2,n'): array|string 
  {
    $DQL = $this->DQL;
    $orden = str_replace(
      array('n', 'a1', 'a2'), 
      array('t.nombres', 't.apellido1', 't.apellido2'), 
      $orden);
    $DQL->concat(explode(',', $orden), 'estudiante_nombre')
          ->concat(explode(',', $orden), 'nombre')
          ->addSelect('de.madre, de.madre_id, de.madre_tel_1, de.madre_email, de.padre, de.padre_id, de.padre_tel_1, de.padre_email')
          ->orderBy('g.orden,s.nombre,'.$orden);
    return $DQL->execute();
  }


  public function getListPadres(int $user_id, string $orden='a1,a2,n'): array|string 
  {
    $lista = (new EstudiantePadres)->getHijos($user_id);
    $filtro = implode(',', $lista);
    $orden = str_replace(
      array('n', 'a1', 'a2'), 
      array('t.nombres', 't.apellido1', 't.apellido2'), 
      $orden
    );
    $DQL = (new OdaDql(__CLASS__))
      ->select('t.*, s.nombre AS salon_nombre, s.grado_id, g.nombre AS grado_nombre')
      ->concat(explode(',', $orden), 'estudiante_nombre')
      ->concat(explode(',', $orden), 'nombre')
      ->leftJoin('salon', 's')
      ->leftJoin('grado', 'g', 's.grado_id=g.id')
      ->where("t.is_active=1")
      ->andWhere("t.id IN ($filtro)")
      ->orderBy('g.orden,s.nombre,'.$orden);
    $DQL->setFrom('sweb_estudiantes');
    return $DQL->execute();
  }


  public function getListPadresRetirados(int $user_id, string $orden='a1,a2,n'): array|string 
  {
    $lista = (new EstudiantePadres)->getHijos($user_id);
    $filtro = implode(',', $lista);
    $orden = str_replace(
      array('n', 'a1', 'a2'), 
      array('t.nombres', 't.apellido1', 't.apellido2'), 
      $orden 
    );    
    $DQL = (new OdaDql(__CLASS__))
        ->select('t.*, s.nombre AS salon_nombre, s.grado_id, g.nombre AS grado_nombre')
        ->concat(explode(',', $orden), 'estudiante_nombre')
        ->concat(explode(',', $orden), 'nombre')
        ->leftJoin('salon', 's')
        ->leftJoin('grado', 'g', 's.grado_id=g.id')
        ->where("t.is_active=1 or (t.is_active=0 and YEAR(t.fecha_ret)=".self::$_annio_actual.")")
        ->andWhere("t.id IN ($filtro)")
        ->orderBy('g.orden,s.nombre,'.$orden);
    $DQL->setFrom('sweb_estudiantes');
    return $DQL->execute();
  }
  

  public function getListPorProfesor(int $user_id, string $orden='a1,a2,n'): array|string 
  {
    $orden = str_replace(
      array('n', 'a1', 'a2'), 
      array('t.nombres', 't.apellido1', 't.apellido2'), 
      $orden
    );
    $CargaProfe = (new SalAsigProf)->getSalones_ByProfesor($user_id);
    $salones = [];
    foreach ($CargaProfe as $carga)
    {
      $salones[] = $carga->salon_id;
    }
    $filtro_in = implode(',', $salones);
    $DQL = new OdaDql(__CLASS__);
    $DQL->setFrom(Config::get('tablas.estudiante'));
    $DQL->select('t.*')
        ->concat(explode(',', $orden), 'estudiante_nombre')
        ->addSelect('s.nombre AS salon_nombre, s.grado_id, g.nombre AS grado_nombre')
        ->leftJoin('salon', 's')
        ->leftJoin('grado', 'g', 's.grado_id=g.id')
        ->where('t.is_active=1')
        ->andWhere("t.salon_id IN($filtro_in)")
        ->orderBy($orden);
    return $DQL->execute();
  }

  
  public function getListPorDirector(int $director_grupo_id, string $orden='a1,a2,n') 
  {
    // OJO :: NO SE USA AQUÍ :::: $director_grupo_id
    try {
      $orden = str_replace(
        array('n', 'a1', 'a2'), 
        array('t.nombres', 't.apellido1', 't.apellido2'), 
        $orden
      );
      $Grupos = (new Usuario)->misGrupos();
      $salones = [];
      foreach ($Grupos as $salon) {
        $salones[] = $salon->id;
      }
      $filtro_in = implode(',', $salones);
      $DQL = (new OdaDql(__CLASS__));
      $DQL->setFrom(Config::get('tablas.estudiante'));
      $DQL->select('t.*')
          ->concat(explode(',', $orden), 'estudiante_nombre')
          ->addSelect('s.nombre AS salon_nombre, s.grado_id, g.nombre AS grado_nombre')
          ->leftJoin('salon', 's')
          ->leftJoin('grado', 'g', 's.grado_id=g.id')
          ->where('t.is_active=1')
          ->andWhere("t.salon_id IN($filtro_in)")
          ->orderBy($orden);
      return $DQL->execute();    
    }
    
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }

  
  public function getListPorCoordinador(int $director_grupo_id, string $orden='a1,a2,n') 
  {
    try {
      $orden = str_replace(
        ['n', 'a1', 'a2'], 
        ['t.nombres', 't.apellido1', 't.apellido2'], 
        $orden
      );
      $Grupos = (new Salon)->getByCoordinador($director_grupo_id);
      $salones = [];
      foreach ($Grupos as $salon)
      {
        $salones[] = $salon->id;
      }
      $filtro_in = implode(',', $salones);
      $DQL = (new OdaDql(__CLASS__));
      $DQL->setFrom(Config::get('tablas.estudiante'));
      $DQL->select('t.*')
          ->concat(explode(',', $orden), 'estudiante_nombre')
          ->addSelect('s.nombre AS salon_nombre, s.grado_id, g.nombre AS grado_nombre')
          ->leftJoin('salon', 's')
          ->leftJoin('grado', 'g', 's.grado_id=g.id')
          ->where('t.is_active=1')
          ->andWhere("t.salon_id IN($filtro_in)")
          ->orderBy($orden);
      return $DQL->execute();
    }
    
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }

    
  public function getSalonesCambiar(string $modulo): string 
  {
    $lnk_cambio = '';
    if ($this->is_active)
    {
      $salonesSig = [ // automatizarlo
        0 => [],
        1 => [1=>'01-A', 3=>'02-A'],
        2 => [3=>'02-A', 5=>'03-A', 6=>'03-B'],
        3 => [5=>'03-A', 6=>'03-B', 7=>'04-A', 24=>'04-B'],
        4 => [7=>'04-A', 24=>'04-B', 8=>'05-A', 26=>'05-B'],
        5 => [8=>'05-A', 26=>'05-B', 21=>'06-A', 25=>'06-B'],
        6 => [21=>'06-A', 25=>'06-B', 20=>'07-A', 28=>'07-B'],
        7 => [20=>'07-A', 28=>'07-B', 19=>'08-A', 31=>'08-B'],
        8 => [19=>'08-A', 31=>'08-B', 18=>'09-A', 34=>'09-B'],
        9 => [18=>'09-A', 34=>'09-B', 17=>'10-A', 35=>'10-B'],
        10 => [17=>'10-A', 35=>'10-B', 16=>'11-A', 36=>'11-B'],
        11 => [16=>'11-A', 36=>'11-B'],
        12 => [15=>'PV-A', 10=>'PK-A'],
        13 => [10=>'PK-A', 12=>'KD-A'],
        14 => [12=>'KD-A', 9=>'TN-A'],
        15 => [9=>'TN-A',  1=>'01-A'],
      ];
      if ( array_key_exists($this->grado_mat, $salonesSig) ) 
      {
        foreach ($salonesSig[$this->grado_mat] as $key_salon => $salon_nombre)
        {
          $lnk_cambio .= Html::link("$modulo/cambiar_salon_estudiante/$this->id/$key_salon/", $salon_nombre, 'class="btn btn-success btn-sm"').'  ';
        }
      }
    }      
    return $lnk_cambio;
  }


  public function getNumEstudiantes_BySalon(int $salon_id): int 
  {
    $DQL = new OdaDql(__CLASS__);
    $DQL->setFrom('sweb_estudiantes');
    $DQL->select('count(*) as total')
        ->groupBy('t.salon_id')
        ->where('t.is_active=1 AND t.salon_id=?')
        ->setParams([$salon_id]);
    $tot = $DQL->execute();
    return ($tot[0]->total ?? 0);
  }



}