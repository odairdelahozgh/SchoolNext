<?php

class UsuariosController extends ScaffoldController
{
    
  public function setPassword(int $id) {
    try {
      $usuario = (new Usuario())::get($id);
      $usuario->setPassword();
  
      return Redirect::to("admin/$this->controller_name/index");
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }

}