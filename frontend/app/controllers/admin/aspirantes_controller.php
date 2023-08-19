<?php
/**
  * Controlador Aspirante
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class AspirantesController extends ScaffoldController
{
  function crear() {
    $id = 0;
    try {
      $this->page_action = "Crear Aspirante";
      $redirect = "admisiones/success";
      //  var_dump(array_filter($_POST, function($k) {
      //   return $k == 'notas';
      //   }, ARRAY_FILTER_USE_KEY));
      //echo include(APP_PATH.'views/_shared/partials/snippets/show_input_post.phtml');
      
      // =================================================================
      // =================================================================
      $post_name_aspir = 'aspirantes';
      if (!Input::hasPost($post_name_aspir)) { OdaFlash::warning("No se guardaron los registros. <br>Se esperaba Post <b>$post_name_aspir</b>, no llegó"); }
      
      $documento = '';
      if (Input::hasPost($post_name_aspir)) {
        $Post = Input::post($post_name_aspir);
        $dataAspir = [];
        foreach ($Post as $field_name => $value) {
          $dataAspir[$field_name] = $value;
          //echo "[$field_name] = $value<br>";
          if ('documento'==$field_name) {
            $documento = $value;
          }
        }
      }//end-foreach

      // AGREGA CAMPOS $dataAdicAspir (DE CONTROL)
      $dataAdicAspir =[];
      $dataAdicAspir['uuid'] = (new Aspirante())->xxh3Hash();
      $dataAdicAspir['created_at'] = date('Y-m-d H:i:s', time());
      $dataAdicAspir['created_by']= 0;
      $dataAdicAspir['updated_at'] = date('Y-m-d H:i:s', time());
      $dataAdicAspir['updated_by']= 0;
      
      // OJO :: despuiés buscar otra alternativa mas eficiente
      $AspExiste = (new Aspirante())::first('Select documento from sweb_aspirantes where documento =?', [$documento]);
      if (isset($AspExiste)) {
        (new Aspirante())::query("DELETE FROM sweb_aspirantes WHERE documento = ?", [$AspExiste->documento]);
        (new AspirantePsico())::query("DELETE FROM sweb_aspirantepsico WHERE aspirante_id = ?", [$AspExiste->id]);
      }
      
      $DQL = new OdaDql((new Aspirante)::class);
      $DQL->insert($dataAspir)
      ->addInsert($dataAdicAspir)
      ->execute();
      
      
      // =================================================================
      // =================================================================
      $aspirante_id = $DQL->getLastInsertId();
      $id = $aspirante_id->last_id??0;
      
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
      $dataAdicAspirPsico['uuid'] = (new AspirantePsico())->xxh3Hash();
      $dataAdicAspirPsico['aspirante_id'] = $id;
      $dataAdicAspirPsico['created_at'] = date('Y-m-d H:i:s', time());
      $dataAdicAspirPsico['created_by']= 0;
      $dataAdicAspirPsico['updated_at'] = date('Y-m-d H:i:s', time());
      $dataAdicAspirPsico['updated_by']= 0;
      
      $DQL = new OdaDql((new AspirantePsico)::class);
      $DQL->insert($dataAspirPsico)
      ->addInsert($dataAdicAspirPsico)
      ->execute();
      
      
      // =================================================================
      // =================================================================
      
      
      OdaFlash::valid("El registro de aspirante #$id ha sido creado satisfactoriamente");
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
    return Redirect::to($redirect."/{$id}");
    
  } //END-crear



} //END-class