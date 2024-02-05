<?php
/**
 * Controller para el manejo de páginas estáticas, aunque
 * se puede utilizar como cualquier otro controller haciendo uso
 * de los Templates, Layouts y Partials.
 * 
 * dominio.com/pages/organizacion/privacidad
 * enseñara la vista views/pages/organizacion/privacidad.phtml
 *
 * dominio.com/pages/aviso
 * enseñara la vista views/pages/aviso.phtml
 *
 * También se puede usar el routes.ini para llamarlo con otro nombre,
 * /aviso = pages/show/aviso
 * Asi al ir a dominio.com/aviso enseñara la vista views/pages/aviso.phtml
 *
 * /organizacion/* = pages/organizacion/*
 * Al ir a dominio.com/organizacion/privacidad 
 * enseñará la vista en views/organizacion/privacidad.phtml
 *
 * Ademas se pueden utilizar Helpers
 * <?= Html::link_to('pages/aviso', 'Ir Aviso') ?>
 * Muestra un enlace que al hacer click irá a dominio.com/pages/aviso
 *
 */
class PagesController extends AppController
{
  
  public function __call($name, $params)
  {
    array_unshift($params, $name);
    View::select(implode('/', $params));
  }


  public function miperfil() 
  {
    try 
    {
      $this->MiUsuario = (new Empleado())->get($this->user_id);
      $this->page_action = 'Mi Perfil';
    } 
    catch (\Throwable $th) 
    {
      OdaFlash::error($th);
    }
  }

  public function index() 
  {
  }


  public function bootstrap() 
  {
    View::template('looper/layout-pagenavs');
  }



}