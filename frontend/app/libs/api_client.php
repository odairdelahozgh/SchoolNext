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
      //  /agendaevents?sortfield=t.id&sortorder=ASC&limit=100
        $ch = curl_init($this->apiUrl . $endpoint);
        $headers = [
            "DOLAPIKEY: {$this->apiToken}",
            "Accept: application/json",
            //"Content-Type: application/json"
        ];
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        //curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($ch, CURLOPT_VERBOSE, true);
        //curl_setopt($ch, CURLOPT_HEADER, true);
        $response = curl_exec($ch);
        if ($response === false)
        {
          OdaLog::alert('cURL error: ' . curl_error($ch));
        } 
        else
        {
          $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
          $header = substr($response, 0, $header_size);
          $body = substr($response, $header_size);
          OdaLog::debug('Response Headers: ' . $header);
          OdaLog::debug('Response Body: ' . $body);
        }
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return [
            'statusCode' => $statusCode,
            'body' => $body ?? null,
        ];
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