<?php
/**
  * Controlador Contabilidad  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */

  
class ContabilidadController extends AppController
{
    
    public function index(): void {
      $this->page_action = 'Inicio';
    } //END-
    

    public function listadoEstudActivos(): void {
      try {
        $this->page_action = 'Listado de Estudiantes Activos';
        $this->data = (new Estudiante)->getListContabilidad();
      
      } catch (\Throwable $th) {
        OdaFlash::error($th);
      }
      View::select(view: 'estudiantes/estudiantes_list');
    } // END-listadoEstudActivos

    
    public function actualizarPago(int $estudiante_id): void { // Actualizar Mes Pagado de un Estudiante
      try {
        $this->page_action = 'Actualizar Mes Pagado Estudiante';
        $Estud = (new Estudiante)->get($estudiante_id);
        if ($Estud->setActualizarPago(estudiante_id: $estudiante_id)) {
          OdaFlash::valid("$this->page_action: $Estud");
        } else {
          OdaFlash::warning("$this->page_action: $Estud");
        }
      
      } catch (\Throwable $th) {
        OdaFlash::error($th);
      }
      Redirect::toAction(action: 'listadoEstudActivos');
    } //END-actualizarPago
    

} // END CLASS
