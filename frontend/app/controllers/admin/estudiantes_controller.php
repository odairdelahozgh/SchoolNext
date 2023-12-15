<?php
/**
  * Controlador  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class EstudiantesController extends ScaffoldController
{

  public function index(): void {
    $this->page_action = "Listado $this->controller_name" ;
    $this->fieldsToShow = (new Estudiante())->getFieldsShow(__FUNCTION__);
    $this->fieldsToShowLabels = (new Estudiante())->getFieldsShow(__FUNCTION__, true);
    $this->data = (new Estudiante())->getListEstudiantes($orden='n,a1,a2');
  }//END-list
  
  public function exportPdf() {
    $this->file_name = OdaUtils::getSlug("listado-de-$this->controller_name");
    $this->file_title = "Listado de $this->controller_name";
    $this->data = (new Estudiante)->getList(estado:1);
    $this->file_download = false;
    View::select(view: "export_pdf_$this->controller_name", template: 'pdf/mpdf');
  } //END-exportPdf

  public function exportEstudiantesBySalonPdf(string $salon_uuid) {
    $RegSalon = (new Salon)::getByUUID($salon_uuid);
    
    $this->file_tipo = "Listado de $this->controller_name";
    $this->file_title = "Listado de $this->controller_name de $RegSalon->nombre";
    $this->file_name = OdaUtils::getSlug("listado-de-$this->controller_name-salon-$RegSalon->nombre");

    $this->data = (new Estudiante)->getListActivosByModulo(modulo: Modulo::Secre, where: ['salon_id'=>$RegSalon->id]);
    
    View::select(view: "secre_pdf_estudiantes_by_salon", template: 'pdf/mpdf');

  } //END-exportPdf

  public function promoverMatriculas(int $grado_id) {
    try {
      $Grados = (new Grado())::all();
      $arrGrados = [];
      foreach ($Grados as $key => $grado) {
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

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-promoverMatriculas


  public function editEstudiante(int $id, string $redirect='') {
    try {
      $redirect = str_replace('.','/', $redirect);
      $this->page_action = 'EDITAR Registro Estudiante';
      
      //  var_dump(
      //    array_filter($_POST, function($k) {
      //    return $k == 'datosestuds';
      //    }, ARRAY_FILTER_USE_KEY)
      //  );
      echo include(APP_PATH.'views/_shared/partials/snippets/show_input_post.phtml');
      

      View::select(null, null);

      $Estudiante = (new Estudiante())::get($id);
      $tabla_datos_estud = Config::get('tablas.datosestud');
      $DatosEstud = (new DatosEstud())::first("SELECT * FROM {$tabla_datos_estud} WHERE estudiante_id=?", [$Estudiante->id]);
      
      // ============================================================================
      // TABLA ESTUDIANTES
      if (!Input::hasPost('estudiantes')) {
        OdaFlash::warning("$this->page_action - No coincide post 'estudiantes'");
        return Redirect::to($redirect);
      }
      if (!$Estudiante->validar(Input::post('estudiantes'))) {
        OdaFlash::warning("$this->page_action - tabla ESTUDIANTES - ".Session::get('error_validacion'));
        return Redirect::to($redirect);
      }
      if ( $Estudiante->update(Input::post('estudiantes')) ) {
        OdaFlash::valid("$this->page_action - Se actualizó tabla ESTUDIANTES");
      } else {
        OdaFlash::warning("$this->page_action - No actualizó el Registro en ESTUDIANTES.");
      }

      // ============================================================================
      // TABLA DATOSESTUDS
      if (!Input::hasPost('datosestuds')) {
        OdaFlash::warning("$this->page_action - No coincide post DATOSESTUDS");
      }
      if (!$DatosEstud->validar(Input::post('datosestuds'))) {
        OdaFlash::warning("$this->page_action. No pudo validar DATOSESTUDS");
      }
      if ( $DatosEstud->update(Input::post('datosestuds')) ) {
        OdaFlash::valid("$this->page_action - Se actualizó tabla DATOSESTUDS"); 
      } else {
        OdaFlash::warning("$this->page_action - No actualizó el Registro en DATOSESTUDS.");
      }
      // ============================================================================


      return Redirect::to($redirect);

    } catch (\Throwable $th) {
      OdaFlash::error($th);
      return Redirect::to($redirect);
    }

  }//END-edit_ajax


} // END CLASS
