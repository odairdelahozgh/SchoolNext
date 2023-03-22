<?php

class EmpleadosController extends ScaffoldController
{
  
  public function setPassDocente(int $id) {
    $user = (new Empleado)::get($id);
    $user->setPassDocente();
    return Redirect::to("admin/$this->controller_name/index");
  }

}