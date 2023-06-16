<?php
/**
  * Controlador Contabilidad  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */

  
class ContabilidadController extends AppController
{
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter(): void {
      $this->page_action = 'M&oacute;dulo Contabilidad';
    }
    
       
    /**
      * Index Básico
      */
    public function index(): void {
      $this->page_title = 'Inicio Contabilidad';
    }    
    

    public function listadoEstudActivos(): void {
      $this->page_action = 'Listado de Estudiantes Activos';
      $this->data = (new Estudiante)->getListEstudiantes(estado:1);
      View::select(view: 'estudiantes/estudiantes_list');
    } // END-listadoEstudActivos

    
    /**
     * Actualizar Mes Pagado de un Estudiante
     */
    public function actualizarPago(int $estudiante_id): void {
      $this->page_action = 'Actualizar Mes Pagado Estudiante';
      $Estud = (new Estudiante)->get(pk: $estudiante_id);
      if ($Estud->setActualizarPago(estudiante_id: $estudiante_id)) {
        OdaFlash::valid(msg: "$this->page_action: $Estud");
      } else {
        OdaFlash::error(msg: "$this->page_action: $Estud", audit: true);
      }
      Redirect::toAction(action: 'listadoEstudActivos');
    } // END-actualizarPago
    

} // END CLASS
