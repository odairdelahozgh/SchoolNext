<?php

/**
  * Controlador Test  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */

class EjemploController extends AppController
{
   //public $theme="w3-theme-red";
   public $page_module = 'Módulo de Ejemplos';

   /**
      * Index Básico
      */
      public function index() {
         Flash::info('Flash info de prueba');
         $this->page_title = 'Inicio';
         
         View::template('test');
      }

      public function validaciones() {
         $this->page_title = 'Validaciones de Formularios';
         //View::template('test');
      }

      public function excel(){
      }

      
   /**
      * Index Básico
      */
      public function dialog() {
         $this->page_title = 'Dialog Ejemplo';
         View::template('test');
      }
     
      public function pdf() {
        View::template(NULL);
        $this->data = 'Hola Mundo';
      }

}