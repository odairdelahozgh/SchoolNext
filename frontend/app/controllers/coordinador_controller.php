<?php
/**
  * Controlador
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class CoordinadorController extends AppController
{
  
  public function showEstudiante(int $estudiante_id) 
  {
    $this->page_action = 'Mostrar Estudiante';
    $this->arrData = [];
    
    try 
    {
      $Estudiante = (new Estudiante())::get($estudiante_id);

      $tabla_datos_estud = Config::get('tablas.datosestud');
      $DatosEstud = (new DatosEstud())::first("SELECT * FROM {$tabla_datos_estud} WHERE estudiante_id=?", [$estudiante_id]);
      
      $tabla_datos_adju = Config::get('tablas.estud_adjuntos');
      $Adjuntos = (new EstudianteAdjuntos())::first("SELECT * FROM {$tabla_datos_adju} WHERE estudiante_id=?", [$estudiante_id]);

      if (!$Adjuntos) 
      {
        $Adjuntos = new EstudianteAdjuntos();
        $Adjuntos->save([
          'estudiante_id' => $estudiante_id,
          'created_by' => $this->user_id,
          'updated_by' => $this->user_id,
          'created_at' => $this->_ahora,
          'updated_at' => $this->_ahora,
        ]);
      }
      $this->arrData['Estudiante'] = $Estudiante;
      $this->arrData['DatosEstud'] = $DatosEstud;
      $this->arrData['Adjuntos']   = $Adjuntos;
    } 

    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select('estudiantes/show_estud/showForm');
  }
  
  
  public function seguimientosConsolidado() 
  {
    try
    {
      $this->page_action = 'Consolidado de Seguimientos';
    }
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select('seguimientos/consolidado');
  }


  public function index() 
  {
    $this->page_action = 'M&oacute;dulo Coordinaci&oacute;n';
  }
  

  public function listadoEstudiantes(): void
  {
    $this->page_action = 'Listado de Estudiantes Activos';
    if (19==$this->user_id) { // solo LIZBETH
      $this->data = (new Estudiante)->getListPorCoordinador($this->user_id);
    }
    else
    {
      $this->data = (new Estudiante)->getListSecretaria(estado:1);
    }
    View::select('estudiantes/index');
  }


  public function gestion_registros() 
  {
    $this->page_action = 'Gesti&oacute;n Registros';
    $this->annios = range((int)Config::get('config.academic.annio_actual'), 2021, -1);
    View::select('registros/index');
  }

  
  public function consolidado() 
  {
    try 
    {
      $this->page_action = 'Consolidado de Notas';
      $this->data = (new Salon())->getByCoordinador(Session::get('id'));
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select('consolidado/index');
  }
  
  
  public function notas_salon_json(int $salon_id) 
  {
    View::template(null);
    $notas = (new Nota())->getNotasSalon($salon_id);
    return json_encode($notas);
  }
  

  public function historico_notas() 
  {
    try 
    {
      $this->page_action = 'Hist&oacute;rico de Notas';
      //$this->data = range(Config::get('config.academic.annio_actual')-1, Config::get('config.academic.annio_inicial'), -1);
      $this->data = range(Config::get('config.academic.annio_actual'), 2010, -1);
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select('historico_notas/index');
  }


  public function cambiar_salon_estudiante(
    int $estudiante_id, 
    int $salon_id, 
    bool $cambiar_en_notas = true) 
  {
    $this->page_action = 'Cambiar de Salón a Estudiante';
    $Estud = (new Estudiante)::first("SELECT * FROM sweb_estudiantes WHERE id=?", [$estudiante_id]);
    if ( $Estud->setCambiarSalon((int)$salon_id, $cambiar_en_notas) ) 
    {
      OdaFlash::valid("$this->page_action: $Estud]");
    } 
    else 
    {
      OdaFlash::warning("$this->page_action: $Estud]");
    }
    return Redirect::to('coordinador/index');//pendiente la redirección..
  }
  

  public function admisiones() 
  {
    try 
    {
      $this->page_action = 'M&oacute;dulo de Admisiones';
      $select = implode(', ', (new Aspirante)::getFieldsShow(show: 'index', prefix: 't.'));
      $this->data = (new Aspirante)->getListActivos(select: $select);
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select('admisiones/index');
  }
  

}