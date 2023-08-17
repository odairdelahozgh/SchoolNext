<?php
/**
  * Controlador Aspirante
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class AspirantesController extends ScaffoldController
{
  function crear() {
    try {      
      $this->page_action = "Crear Aspirante";
      $redirect = "admisiones";
      //  var_dump(array_filter($_POST, function($k) {
      //   return $k == 'notas';
      //   }, ARRAY_FILTER_USE_KEY));
      //echo include(APP_PATH.'views/_shared/partials/snippets/show_input_post.phtml');
      
      // =================================================================
      // =================================================================
      $post_name_aspir = 'aspirantes';
      if (!Input::hasPost($post_name_aspir)) { OdaFlash::warning("No se guardaron los registros. <br>Se esperaba Post <b>$post_name_aspir</b>, no llegó"); }

      if (Input::hasPost($post_name_aspir)) {
        $Post = Input::post($post_name_aspir);
        $dataAspir = [];
        foreach ($Post as $field_name => $value) {
          $dataAspir[$field_name] = $value;
          //echo "[$field_name] = $value<br>";
        }
      }//end-foreach

      // AGREGA CAMPOS $dataAdicAspir (DE CONTROL)
      $dataAdicAspir =[];
      $dataAdicAspir['created_at'] = date('Y-m-d H:i:s', time());
      $dataAdicAspir['created_by']= 0;
      $dataAdicAspir['updated_at'] = date('Y-m-d H:i:s', time());
      $dataAdicAspir['updated_by']= 0;
      
      // buscar por numero documento...
      // si está lo elimina... y listo...
      // despuiés buscar otra alternativa mas eficiente

      $Modelo = (new Aspirante());
      $DQL = new OdaDql($Modelo::class);
      $DQL->insert($dataAspir)
               ->addInsert($dataAdicAspir)
               ->execute(true);

      
      // =================================================================
      // =================================================================
      $aspirante_id = $DQL->getLastInsertId();
      $post_name_aspir_psico = 'aspirantepsicos';
      if (!Input::hasPost($post_name_aspir_psico)) { OdaFlash::warning("No se guardaron los registros. <br>Se esperaba Post <b>$post_name_aspir_psico</b>, no llegó"); }

      if (Input::hasPost($post_name_aspir_psico)) {
        $Post = Input::post($post_name_aspir_psico);
        $dataAspirPsico = [];
        foreach ($Post as $field_name => $value) {
          $dataAspirPsico[$field_name] = $value;
          //echo "[$field_name] = $value<br>";
        }
      }//end-foreach

      // AGREGA CAMPOS DE CONTROL
      $dataAdicAspirPsico =[];
      $dataAdicAspirPsico['aspirante_id'] = $aspirante_id->id ?? 1;
      $dataAdicAspirPsico['created_at'] = date('Y-m-d H:i:s', time());
      $dataAdicAspirPsico['created_by']= 0;
      $dataAdicAspirPsico['updated_at'] = date('Y-m-d H:i:s', time());
      $dataAdicAspirPsico['updated_by']= 0;
        
      $Modelo = (new AspirantePsico());
      $DQL = new OdaDql($Modelo::class);
      $DQL->insert($dataAspirPsico)
               ->addInsert($dataAdicAspirPsico)
               ->execute(true);

      
      // =================================================================
      // =================================================================


      return Redirect::to($redirect);

    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-crear



} //END-class