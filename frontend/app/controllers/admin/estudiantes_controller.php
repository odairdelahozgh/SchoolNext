<?php
/**
  * Controlador Areas  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class EstudiantesController extends ScaffoldController
{

  /**
   * admin/.../index
   */
  public function index() {
    //(new Estudiante())->setUUID_All_ojo();
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


} // END CLASS
