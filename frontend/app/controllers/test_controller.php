<?php
/**
  * Controlador  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
class TestController extends AppController
{
  // $this->module_name, $this->controller_name, $this->action_name, 
  // $this->parameters, $this->limit_params, $this->scaffold, $this->data
  protected function before_filter() 
  {
    View::template('adminlite4-template');
  }

  public function index2() 
  {
    View::select(null, null);
    try
    {
      $apiClient = new ApiClient(
        Config::get('dolibarr.'.INSTITUTION_KEY.'.api_url'), 
        Config::get('dolibarr.'.INSTITUTION_KEY.'.api_key')      
      );
      $this->data = $apiClient->get('/agendaevents');
    }
    catch (\Throwable $th)
    {
      OdaFlash::error($th, true);
    }
  
  }


  public function index()
  {
    $id_photo = (Session::get('documento') !=$this->user_id) ? Session::get('documento') : $this->user_id;
    $this->user = [
      'username' => $this->user_name,
      'name' => $this->user_nombre_completo,
      'image' => 'img/upload/users/'.$id_photo.'.png',
      'title' => '',
      'profile_link' => 'pages/miperfil',
      'signout_link' => 'logout'
    ];
  }

  
}