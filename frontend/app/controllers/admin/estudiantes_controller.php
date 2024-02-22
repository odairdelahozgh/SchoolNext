<?php
/**
  * Controlador  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class EstudiantesController extends ScaffoldController
{

  public function index(): void 
  {
    $this->page_action = "Listado $this->controller_name" ;
    $this->fieldsToShow = (new Estudiante())->getFieldsShow(__FUNCTION__);
    $this->fieldsToShowLabels = (new Estudiante())->getFieldsShow(__FUNCTION__, true);
    $this->data = (new Estudiante())->getListEstudiantes($orden='n,a1,a2');
  }


  public function exportListMatriculadosPdf(): void 
  {
    $this->file_title = "Listado de Estudiantes Matriculados";
    $this->file_name = OdaUtils::getSlug($this->file_title);
    $this->data = (new Estudiante)->getListMatriculados();
    $this->file_download = false;
    View::select(view: "export_pdf_matriculados", template: 'pdf/mpdf');
  }
  

  public function exportListPendientesMatriculaPdf(): void 
  {
    $this->file_title = "Listado de Estudiantes Pendientes x Matricular";
    $this->file_name = OdaUtils::getSlug($this->file_title);
    $this->data = (new Estudiante)->getListPendientesMatricula();
    $this->file_download = false;
    View::select(view: "export_pdf_pendientes_matricula", template: 'pdf/mpdf');
  }
  

  public function exportPdf(): void 
  {
    $this->file_name = OdaUtils::getSlug("listado-de-$this->controller_name");
    $this->file_title = "Listado de $this->controller_name";
    $this->data = (new Estudiante)->getList(estado:1);
    $this->file_download = false;
    View::select(view: "export_pdf_$this->controller_name", template: 'pdf/mpdf');
  }


  public function exportEstudiantesBySalonPdf(string $salon_uuid) 
  {
    $RegSalon = (new Salon)::getByUUID($salon_uuid);
    $this->file_tipo = "Listado de $this->controller_name";
    $this->file_title = "Listado de $this->controller_name de $RegSalon->nombre";
    $this->file_name = OdaUtils::getSlug("listado-de-$this->controller_name-salon-$RegSalon->nombre");
    $this->data = (new Estudiante)->getListActivosByModulo(modulo: Modulo::Secre, where: ['salon_id'=>$RegSalon->id]);    
    View::select(view: "secre_pdf_estudiantes_by_salon", template: 'pdf/mpdf');
  }


  public function promoverMatriculas(int $grado_id) 
  {
    try
    {
      $Grados = (new Grado())::all();
      $arrGrados = [];
      foreach ($Grados as $key => $grado) 
      {
        $arrGrados[$grado->id]['proximo_grado'] = $grado->proximo_grado;
        $arrGrados[$grado->id]['salon_default'] = $grado->salon_default;
      }      
      $perdieron_annio = ['2313, 2276, 1769, 1443'];
      $DQLEstudiantes = new OdaDql('Estudiante');
      $DQLEstudiantes->setFrom('sweb_estudiantes');      
      $nuevo_grado = $arrGrados[$grado_id]['proximo_grado'];
      $data = [
        'is_habilitar_mat' => 1, 
        'annio_promovido' => 2024, 
        'grado_promovido' => $nuevo_grado, 
        'numero_mat' => '', 
      ];
      $DQLEstudiantes->update($data)
        ->where(' (t.is_active=1) and (t.id not in (2313, 2276, 1769, 1443)) and (t.grado_mat=?')
        ->setParams([$grado_id]);
      $DQLEstudiantes->execute();
      redirect::to('secre-estud-list-activos');
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }


  public function editEstudiante(int $id, string $redirect='') 
  {
    try
    {
      $redirect = str_replace('.','/', $redirect);
      $this->page_action = 'EDITAR Registro Estudiante';
      echo include(APP_PATH.'views/_shared/partials/snippets/show_input_post.phtml');
      View::select(null, null);      
      // ============================================================================
      // TABLA ESTUDIANTES
      if (!Input::hasPost('estudiantes')) 
      {
        OdaFlash::warning("$this->page_action - No coincide post 'estudiantes'");
        return Redirect::to($redirect);
      }
      if (!(new Estudiante)->validar(Input::post('estudiantes')))
      {
        OdaFlash::warning("$this->page_action - tabla ESTUDIANTES - ".Session::get('error_validacion'));
        return Redirect::to($redirect);
      }
      if ( (new Estudiante)->update(Input::post('estudiantes')) )
      {
        OdaFlash::valid("$this->page_action - Se actualizó tabla ESTUDIANTES");
      }
      else
      {
        OdaFlash::warning("$this->page_action - No actualizó el Registro en ESTUDIANTES.");
      }
      // ============================================================================
      // TABLA DATOSESTUDS
      if (!Input::hasPost('datosestuds'))
      {
        OdaFlash::warning("$this->page_action - No coincide post DATOSESTUDS");
      }
      if (!(new DatosEstud)->validar(Input::post('datosestuds')))
      {
        OdaFlash::warning("$this->page_action. No pudo validar DATOSESTUDS");
      }
      if ( !(new DatosEstud)->update(Input::post('datosestuds')) )
      {
        OdaFlash::warning("$this->page_action - No actualizó el Registro en DATOSESTUDS.");
      }
      // ============================================================================
      // TABLA EstudianteAdjuntos
      if (!Input::hasPost('estudianteadjuntos'))
      {
        OdaFlash::warning("$this->page_action - No coincide post estudianteadjuntos");
      }
      if (!(new EstudianteAdjuntos)->validar(Input::post('estudianteadjuntos')))
      {
        OdaFlash::warning("$this->page_action. No pudo validar estudianteadjuntos");
      }
      if ( !(new EstudianteAdjuntos)->update(Input::post('estudianteadjuntos')) )
      {
        OdaFlash::warning("$this->page_action - No actualizó el Registro en estudianteadjuntos.");
      }      
      return Redirect::to($redirect);
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
      return Redirect::to($redirect);
    }
  }


  public function exportDocsMatricula(int $estudiante_id) 
  {
    try
    {
      $this->data = (new Estudiante())->get($estudiante_id);
      $tabla_datosestud = Config::get('tablas.datosestud');
      $tabla_grados = Config::get('tablas.grados');
      $this->arrData['DatosEstud'] = (new DatosEstud())->first("SELECT * FROM {$tabla_datosestud} WHERE estudiante_id=?", [$estudiante_id]);
      $this->arrData['Grado'] = (new Grado())->first("SELECT * FROM {$tabla_grados} WHERE id=?", [$this->data->grado_promovido]);
      $this->file_tipo = '';
      $this->file_name = OdaUtils::getSlug("DOC-MAT-ESTUD");
      $this->file_title = OdaUtils::getSlug("DOC-MAT-ESTUD");
      View::select(view: "export_pdf_docs_matriculas", template: null);    
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }


  public function generarNumeroMatricula(int $estudiante_id) 
  {
    try 
    {
      $Estud = (new Estudiante())->get($estudiante_id);
      if ( ($Estud) and ((0==$Estud->numero_mat) or (is_null($Estud->numero_mat))) )
      {
        $DQL = new OdaDql('Estudiante');
        $DQL->setFrom('sweb_estudiantes');
        $next_numero_mat = $DQL->getMax('numero_mat') + 1;
        $DQL->update(['numero_mat' => $next_numero_mat])
            ->where('t.id=?')
            ->setParams([$estudiante_id])
            ->execute();
      }
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
    return redirect::to('secre-estud-list-activos');
  }


  public function vincularPadresHijos(int $estudiante_id) 
  {
    EstudiantePadres::vincularPadresHijos($estudiante_id);
    return Redirect::to('admin/estudiantes');
  }

}