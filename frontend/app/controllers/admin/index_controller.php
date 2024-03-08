<?php

/**
 * Controller por defecto en admin
 *
 */
class IndexController extends AppController
{

  public function index() 
  {
    try
    {
      $this->page_action = 'M&oacute;dulo Admin';
      $this->data = (new Evento)->getEventosDashboard();
      if ('looper' == Config::get('config.theme.admin'))
      {        
        View::select(view: 'layout-pagenavs', template: 'looper/layout-pagenavs');
      }
    }

    catch (\Throwable $th)
    {
      OdaFlash::error($th);
    }
  }



}