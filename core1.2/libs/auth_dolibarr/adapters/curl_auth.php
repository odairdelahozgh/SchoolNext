<?php
/**
 * KumbiaPHP web & app Framework
 * @category   Kumbia
 * @package    Auth
 * @subpackage Adapters
 */

/**
 * Clase de Autenticacón a API DOLIBARR através de cURL
 *
 * @category   Kumbia
 * @package    Auth
 * @subpackage Adapters
 */
class CurlAuth extends AuthDolibarr
{
    protected $_model = 'users';
    protected $_sessionNamespace = 'default';
    protected $_fields = array('id');
    protected $_algos ;
    protected $_key;
    public function setModel($model) { $this->_model = $model; }
    public function setSessionNamespace($namespace) { $this->_sessionNamespace = $namespace; }
    public function setFields($fields) { $this->_fields = $fields; }

    protected function _check($username, $password)
    {
      $apiUrl = Config::get('dolibarr.'.INSTITUTION_KEY.'.api_url');
      $apiKey = Config::get('dolibarr.'.INSTITUTION_KEY.'.api_key');
      $HTTPHeader = ['DOLAPIKEY: '.$apiKey];
      
      $Curl = curl_init();
      $endPointLogin = $apiUrl.'/login?login='.$username.'&password='.$password;      
      curl_setopt($Curl, CURLOPT_URL, $endPointLogin);
      curl_setopt($Curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($Curl, CURLOPT_HTTPHEADER, $HTTPHeader);
      $result_json = curl_exec($Curl);
      
      if (curl_errno($Curl))
      {
        $err_message = "Error en la solicitud cURL: " . curl_error($Curl);
        $this->setError($err_message);
        Session::set($this->_key, FALSE);
        return false;
      }
      else
      {
        $dataLogin = json_decode($result_json, true);

        //self::log('==== dataLogin ====');
        //self::log($dataLogin);

        if (isset($dataLogin['error'])) {
          $err_message = "Error del API: " . $dataLogin['error']['message'];
          $this->setError($err_message);
          Session::set($this->_key, FALSE);
          return false;
        }
        else
        {
          // USUARIO AUTENTICADO CORRECTAMENTE
          $token = $dataLogin['success']['token'];
          curl_close($Curl);
          
          // INFORMACIÓN DEL USUARIO
          $Curl = curl_init();

          $endPoint = $apiUrl."/users/login/{$username}?includepermissions=0";
          $HTTPHeader = ['DOLAPIKEY: '.$token];
          curl_setopt($Curl, CURLOPT_URL, $endPoint);
          curl_setopt($Curl, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($Curl, CURLOPT_HTTPHEADER, $HTTPHeader);
          $result_json = curl_exec($Curl);
          $dataUserInfo = json_decode($result_json, true);

          //self::log('==== dataUserInfo ====');
          //self::log($dataUserInfo);

          curl_close($Curl);
          

          // INFORMACIÓN DE LOS << GRUPOS >> AL QUE PERTECENE EL USUARIO
          $Curl = curl_init();
          $endPoint = $apiUrl.'/users/'.$dataUserInfo['id'].'/groups';
          $HTTPHeader = ['DOLAPIKEY: '.$token];
          curl_setopt($Curl, CURLOPT_URL, $endPoint);
          curl_setopt($Curl, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($Curl, CURLOPT_HTTPHEADER, $HTTPHeader);
          $result_json = curl_exec($Curl);
          $dataUserGroups = json_decode($result_json, true);
          
          //self::log('==== dataUserGroups ====');
          //self::log($endPoint);
          //self::log($dataUserGroups);

          curl_close($Curl);

          $roll = '';
          if ('admin'==strtolower($dataUserInfo['login']))
          {
            $roll = 'admin';
          }
          else 
          {
            $losGrupos = [];
            foreach ($dataUserGroups as $key => $grupo) 
            {
              $losGrupos[]=strtolower(trim($grupo['name']));
            }
            
            self::log($losGrupos);
            // Definir los grupos en el orden de prioridad
            $gruposPrioritarios = ["docentes", "padres", "secretarias", "contabilidad", "coordinadores"];
            // Buscar el primer grupo que coincida en los grupos prioritarios
            $roll = '';
            foreach ($gruposPrioritarios as $grupo) {
              if (in_array($grupo, $losGrupos)) {
                $roll = $grupo;
                break;
              }
            }
            //self::log($roll);
          }

          Session::set('id', $dataUserInfo['id'], $this->_sessionNamespace);
          Session::set('token', $token, $this->_sessionNamespace);
          Session::set('username', (string)$username, $this->_sessionNamespace);
          Session::set('password', (string)$password, $this->_sessionNamespace);
          Session::set('nombres', (string)$dataUserInfo['firstname'], $this->_sessionNamespace);
          Session::set('apellido1', (string)$dataUserInfo['lastname'], $this->_sessionNamespace);
          Session::set('apellido2', '', $this->_sessionNamespace);
          Session::set('roll', $roll, $this->_sessionNamespace);
          Session::set('documento', (string)$dataUserInfo['array_options']['options_identificacion'], $this->_sessionNamespace);
          Session::set('usuario_instit', '', $this->_sessionNamespace);
          Session::set('clave_instit', '', $this->_sessionNamespace);
          Session::set('theme', 'dark', $this->_sessionNamespace);
          Session::set($this->_key, TRUE);
          return TRUE;
        }
      }
      
    }

}