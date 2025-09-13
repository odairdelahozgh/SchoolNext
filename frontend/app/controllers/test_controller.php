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
    View::template('layout_adminlte4');
  }

  public function index()
  {
    $this->page_action = 'Test Page';
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


  public function api_dolibarr()
  {
    try {
      $this->page_action = 'Test Dolibarr';
      $this->action_name = 'api_dolibarr';
      $this->page_title = 'Test API Dolibarr';
      $this->data = [0];
      $apiUrl = (string)Config::get('dolibarr.'.INSTITUTION_KEY.'.api_url');
      $apiKey = (string)Config::get('dolibarr.'.INSTITUTION_KEY.'.api_key');
      
      $apiClient = new ApiClient($apiUrl, $apiKey);
      $response = $apiClient->get('/agendaevents?sortfield=t.id&sortorder=ASC&limit=100');
      if ($response['statusCode'] == 200)
      {
        //$this->data = json_decode($response['body'], true);
        $this->data = $response;
      }
      
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }
  

}