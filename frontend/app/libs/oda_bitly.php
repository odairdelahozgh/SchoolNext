<?php

class OdaBitly{
   private $usuario;
   private $llave;
   private $version_API = "version=2.0.1";
   private $servicio_web = "http://api.bit.ly/";
   
   function __construct($login, $APIkey){
      $this->usuario = "login=" . $login;
      $this->llave = "apiKey=" . $APIkey;
   }
   
   private function muestra_respuesta($respuesta_API){
      echo "<pre>";
      var_dump($respuesta_API);
      echo "</pre>";
   }
   
   public function acorta_URL($URL_larga){
      $query_URL = "&longUrl=" . urlencode($URL_larga);
      
      $URL_consulta_API = $this->servicio_web . "shorten?" . $this->version_API . "&" . $query_URL . "&" . $this->usuario . "&" . $this->llave;
      $respuesta_API = json_decode(file_get_contents($URL_consulta_API), true);
      
      //muestro la resupuesta
      //$this->muestra_respuesta($respuesta_API);
      
      if($respuesta_API["errorMessage"]==""){
         //Todo bien, pues no hay errores
         return $respuesta_API["results"][$URL_larga]["shortUrl"];
      }
      
      return false;   
   }
   
   public function expande_URL($URL_corta){
      $query_URL = "&shortUrl=" . urlencode($URL_corta);
      $solo_codigo_bitly = substr(strstr($URL_corta, "bit.ly/"),7);
      
      $URL_consulta_API = $this->servicio_web . "expand?" . $this->version_API . $query_URL . "&" . $this->usuario . "&" . $this->llave;
      $respuesta_API = json_decode(file_get_contents($URL_consulta_API), true);
      
      //muestro la resupuesta
      //$this->muestra_respuesta($respuesta_API);
      
      if($respuesta_API["errorMessage"]==""){
         //Todo bien, pues no hay errores
         return $respuesta_API["results"][$solo_codigo_bitly]["longUrl"];
      }
      
      return false;
   }
}