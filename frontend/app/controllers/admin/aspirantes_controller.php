<?php
/**
  * Controlador Aspirante
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class AspiranteController extends ScaffoldController
{
  function guardar() {
    $this->page_action = "Guardar Notas";
    $redirect = "aspirantes";
    //  var_dump(array_filter($_POST, function($k) {
    //   return $k == 'notas';
    //   }, ARRAY_FILTER_USE_KEY));
    //echo include(APP_PATH.'views/_shared/partials/snippets/show_input_post.phtml');

    try {

          // AGREGA CAMPOS ADICIONALES (DE CONTROL)
          $adicionales =[];
          $adicionales['updated_at']= date('Y-m-d H:i:s', time());
          $adicionales['updated_by']= $this->user_id;
          
          // UPDATE SQL PURO
          $Modelo = (new Aspirante());
          /*
          $DQL = new OdaDql($Modelo::class);
          $DQL->update($data)
          ->addUpdate($adicionales)
          ->where("t.id=?")
          ->setParams([$id])
          ->execute();
          */

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
    return Redirect::to(route: $redirect);

  } //END-guardar

} //END-class