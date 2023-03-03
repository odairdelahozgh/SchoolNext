<?php

/**
 * Controller por defecto en admin
 *
 */
class IndexController extends AppController
{
    public function index() {
        $this->page_action = 'M&oacute;dulo Admin';
        $this->data = (new Evento)->getEventosDashboard();
      }

}
