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
         $this->ejemplo = new Ejemplo();
         View::template('test');
      }

      public function validaciones() {
         $this->page_title = 'Validaciones de Formularios';
         
         View::template('test');
      }

      public function excel(){
         $this->header = array(
            'c1-text'=>'string',//text
            'c2-text'=>'@',//text
            'c3-integer'=>'integer',
            'c4-integer'=>'0',
            'c5-price'=>'price',
            'c6-price'=>'#,##0.00',//custom
            'c7-date'=>'date',
            'c8-date'=>'YYYY-MM-DD',
          );
          $this->rows = array(
            array('x101',102,103,104,105,106,'2018-01-07','2018-01-08'),
            array('x201',202,203,204,205,206,'2018-02-07','2018-02-08'),
            array('x301',302,303,304,305,306,'2018-03-07','2018-03-08'),
            array('x401',402,403,404,405,406,'2018-04-07','2018-04-08'),
            array('x501',502,503,504,505,506,'2018-05-07','2018-05-08'),
            array('x601',602,603,604,605,606,'2018-06-07','2018-06-08'),
            array('x701',702,703,704,705,706,'2018-07-07','2018-07-08'),
          );
      }

      
   /**
      * Index Básico
      */
      public function dialog() {
         $this->page_title = 'Dialog Ejemplo';
         View::template('test');
      }
}