<?php
/**
 * Simple API Client using cURL
 * @category  Library
 * @package   ApiClient
 * */
class ApiClient
{
    public function __construct(
      protected string $apiUrl, 
      protected string $apiToken)
    {
    }
    protected function request($method, $endpoint, $data = [])
    {
      $response =[
        'statusCode' => 0,
        'headers' => '',
        'error' => '',
        'body' => '',
      ];

      $HTTPHeader = ['DOLAPIKEY: '.$this->apiToken];
      $Curl = curl_init();
      curl_setopt($Curl, CURLOPT_URL, $this->apiUrl.$endpoint);
      curl_setopt($Curl, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($Curl, CURLOPT_HTTPHEADER, $HTTPHeader);
      $result_json = curl_exec($Curl);
      
      $error = '';
      if (curl_errno($Curl))
      {
        $error = "Error en la solicitud cURL: " . curl_error($Curl);
        return $response;
      }

      $dataLogin = json_decode($result_json, true);
      if (isset($dataLogin['error']))
      {
        $error = "Error del API: " . $dataLogin['error']['message'];
        return $response;
      }
      curl_close($Curl);
      return $response;


/*         $ch = curl_init();
        $HTTPHeader = ['DOLAPIKEY: '.$this->apiToken];
        curl_setopt($ch, CURLOPT_URL, $this->apiUrl.$endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, $method);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $HTTPHeader);
        $response = curl_exec($ch);
        $error = '';
        if ($response === false)
        {
          $error = curl_error($ch);
        } 
        else
        {
          $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
          $header = substr($response, 0, $header_size);
          $body = substr($response, $header_size);
        }
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [
            'statusCode' => $statusCode,
            'headers' => $header,
            'error' => $error,
            'body' => $body,
        ]; */
    }


    public function get($endpoint)
    {
        return $this->request('GET', $endpoint);
    }

    public function post($endpoint, $data)
    {
        return $this->request('POST', $endpoint, $data);
    }

    public function put($endpoint, $data)
    {
        return $this->request('PUT', $endpoint, $data);
    }

    public function delete($endpoint)
    {
        return $this->request('DELETE', $endpoint);
    }

    public function update($endpoint, $data)
    {
        return $this->put($endpoint, $data);
    }

    
}