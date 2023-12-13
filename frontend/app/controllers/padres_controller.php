<?php
/**
  * Controlador Padres  
  * @category App
  * @package Controllers 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class PadresController extends AppController
{

  protected function before_filter() {
    if ( !str_contains('padres', Session::get('roll')) && !str_contains('admin', Session::get('roll')) ) {
      OdaFlash::warning('No tiene permiso de acceso al módulo PADRES, fué redirigido');
      Redirect::to(Session::get('modulo'));
    }
  } //END-before_filter


  public function index(): void {
    $this->page_action = 'Inicio';
    Redirect::toAction('estudiantes');
  } //END-index
  
  
  public function contabilidad(): void {
    $this->page_action = 'Información Contable';
  } //END-contabilidad
  

  public function estudiantes(): void {
    try {
    $this->page_action = 'Estudiantes a Cargo';
    $this->arrData['periodo'] = Session::get('periodo');

    $user_id = (1!=$this->user_id) ? $this->user_id : 22482 ; // simular un usuario de padres
    $this->data = (new Estudiante)->getListPadres($user_id);
    
    } catch (\Throwable $th) {
    OdaFlash::error($th);
    }
    View::select('estudiantes/index');
  } //END-estudiantes
  
  
  public function matriculas(): void {
    $this->page_action = 'Matr&iacute;culas Año '.Config::get('matriculas.annio_mat');
    
    $arr_padres_id = [22204, 21985, 22065];
    $rnd =$arr_padres_id[rand(0, count($arr_padres_id)-1)]; 
    $user_id = (1!=$this->user_id) ? $this->user_id : $rnd ;
    
    $this->data = (new Estudiante)->getListPadres($user_id);
    foreach ($this->data as $estudiante) {
      $Adjuntos = (new EstudianteAdjuntos())::filter("WHERE estudiante_id=?", [$estudiante->id]);
      if (!$Adjuntos) {
        $Adjuntos = (new EstudianteAdjuntos());
        $Adjuntos->save([
          'estudiante_id'=>$estudiante->id, 
          'uuid'=>$Adjuntos->xxh3Hash(), 
          'created_at'=> '',
          'updated_at'=> '',
          'created_by'=> $user_id,
          'updated_by'=> $user_id,
          'estado_archivo1'=> EstadoAdjuntos::Revision->value,
          'estado_archivo2'=> EstadoAdjuntos::Revision->value,
          'estado_archivo3'=> EstadoAdjuntos::Revision->value,
          'estado_archivo4'=> EstadoAdjuntos::Revision->value,
          'estado_archivo5'=> EstadoAdjuntos::Revision->value,
          'estado_archivo6'=> EstadoAdjuntos::Revision->value,
        ]);
      }
    }

    View::select('matriculas/index');
  } //END-matriculas
  
  public function subirArchivos($estudiante_id): void {
    try {
      $this->page_action = 'Subir Archivos';
      $this->arrData['Adjuntos'] = (new EstudianteAdjuntos())::filter("WHERE estudiante_id=?", [$estudiante_id]);
      View::select('matriculas/upload');
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-subirArchivos


} // END CLASS
