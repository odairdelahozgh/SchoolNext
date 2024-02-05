<?php
/**
  * Controlador
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */

class DocentesController extends AppController
{
  

  public function index(): void 
  {
    try 
    {
      $this->page_action = 'Direcci&oacute;n de Grupo';
      $periodo = Session::get('periodo');
      $this->data = (new usuario)->misGrupos();
      for ($i=1; $i <=$periodo ; $i++) 
      { 
        $a_regs = (new Nota)::getNotasPromAnnioPeriodoSalon($i, $this->data[0]->id);
        foreach ($a_regs as $key => $value) 
        {
          $this->arrData[$value->asignatura_nombre][$i]['avg'] = $value->avg;
        }
      }
      $this->buttons = [];
      foreach ($this->data as $key => $salon) 
      {
        $this->buttons[$key] = ['caption'=>$salon, 'action'=>"traer_data($salon->id)"];
      }
      
    }
    catch (\Throwable $th) 
    {
        OdaFlash::error($th);
    }
  }


  public function registros() 
  {
    try 
    {
      $this->page_action = 'Registros del Grupo';
      $this->data = range((int)Config::get('config.academic.annio_actual'), 2021, -1);
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select('registros/dg_registros_consoli');
  }  
  

  public function seguimientos() 
  {
    try 
    {
      $this->page_action = 'Seguimientos del Grupo';
      $this->data = (new usuario)->misGrupos();
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
    View::select('seguimientos/dg_seguimientos_consoli');
  }



}