<?php

class OdaBitlyV4 {
  public string $short_url = '';
  private string $access_token = '';
  private string $servicio_web = '';
   
  function __construct() {
    $this->access_token = Config::get('config.bitly.access_token');
    $this->servicio_web = Config::get('config.bitly.servicio_web');
  }
   
   public function __toString(): string {
      return $this->short_url;
   }

   /* make a URL small */
  function make_bitly_url($long_url) {
    /*
    $url_bitly = $this->servicio_web. $this->access_token .'&longUrl='.urlencode($url);
    $response = file_get_contents($url_bitly);
    $json = @json_decode($response, true);
    $this->short_url = $json['results'][$url]['shortUrl'];
    */
    $data = array( 'long_url' => $long_url );
    $payload = json_encode($data);
    $header = array(
      'Authorization: Bearer ' . $this->access_token,
      'Content-Type: application/json',
      'Content-Length: ' . strlen($payload)
    );

    $ch = curl_init($this->servicio_web);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    $this->short_url = curl_exec($ch);
  }//END-make_bitly_url

}//END-CLASS



// returns:  http://bit.ly/11Owun