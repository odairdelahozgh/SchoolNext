<?php
/**
  * Controlador Matriculas  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class MatriculasController extends AppController
{
    //public $theme="w3-theme-red";
    // FILTROS de AppControler: Initialize --> BeforeFilter --> AfterFilter --> Finalize.
    // =======================
    // Útiles para comprobaciones a nivel de aplicación:
    // [verificar el módulo que se esta intentando acceder, sesiones de usuarios, etc. 
    // Igualmente se puede usar para proteger nuestro controlador de información inadecuada.
    
    /**
     * Filtro Initialize: Se llama antes de ejecutar el controlador
     * @return false|void
     */
    // protected function initialize() { }
    
    /**
     * Método que se ejecuta antes de cualquier acción
     */
    protected function before_filter() {
      $this->page_module = 'Módulo Matrículas';
    }
    
    /**
    * AfterFilter
    * @return false|void
    */
    // protected function after_filter() { }
    
    /**
     * Filtro Finalize: Se llama después de ejecutar el controlador
     * @return false|void
     */
    // protected function finalize() { }

    // VARIABLES DEL CONTROLADOR
    // ==========================
    // $this->module_name, $this->controller_name, $this->parameters, $this->action_name
    // $this->limit_params, $scaffold, $data
    
    /**
      * Index Básico
      */
    public function index() {
    }    
    

} // END CLASS
