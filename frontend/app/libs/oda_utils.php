<?php

use LDAP\Result;

/**
 * Clase con diversas utilidades
 * ::camelcase($str, $lower = false)
 * ::smallcase($str)
 * ::smallcase($str)
 * ::underscore($str)
 * ::dash($str)
 * ::humanize($str)
 * ::getParams($params)
 * ::encomillar($lista)
 * 
 * @package     Libs
 */


class OdaUtils extends Util {
    
  const GENERO = [
    'M' => 'Masculino',
    'F' => 'Femenino',
  ];
    
  const MESES = [
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Septiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Diciembre',
  ];
    
  const DIAS_SEMANA = [
    1 => 'Domingo',
    2 => 'Lunes',
    3 => 'Martes',
    4 => 'Miercoles',
    5 => 'Jueves',
    6 => 'Viernes',
    7 => 'Sábado',
  ];
  
  const IS_ACTIVE = [
    0 => 'Activo',
    1 => 'Inactivo',
  ];

  const IS_VISIBLE = [
    0 => 'Visible',
    1 => 'Invisible',
  ];
    
  
  /**
     * Obtiene el nombre del mes (valor numérico)
     */
    public static function nombreMes(int $mes=0): string {
        return match((int)$mes) {
            1       => 'Enero',
            2       => 'Febrero',
            3       => 'Marzo',
            4       => 'Abril',
            5       => 'Mayo',
            6       => 'Junio',
            7       => 'Julio',
            8       => 'Agosto',
            9       => 'Septiembre',
            10      => 'Octubre',
            11      => 'Noviembre',
            12      => 'Diciembre',
            default => 'Mes no existe',
        };
    } // END-nombreMes


    public static function ver_array(array $var) {
        return '<pre>' .print_r($var).'</pre>';
    }

    /**
     * Obtiene el nombre del Género
     */
    public static function nombreGenero(string $abrev): string {
        return match($abrev) {
            'M'  => self::GENERO['M'],
            'F'  => self::GENERO['F'],
            default => 'Género no existe',
        };
    } // END-nombreGenero

    /**
     * Genera una cadena de caracteres aleatrorios.
     */
    public static function randomString($length = 8) {
        $values = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $len_values = strlen($values)-1;
        $strRand = '';
        for ( $i = 0; $i < $length; $i++ ) {
          $strRand .= $values[rand( 0, $len_values )];
        }
        return $strRand;
    } // END-randomString

    /**
     * Retorna la misma cadena truncada.
     */
    public static function truncate(
        string $text, 
        int $length = 30, 
        string $truncateString = '...', 
        bool $truncateLastspace = false
    ): string {
        if(is_array($text)) {
            throw new KumbiaException('No puede truncar un array: '.implode(', ', $text));
        }
        $text = (string) $text;
        if (mb_strlen($text) > $length) {
            $text = mb_substr($text, 0, $length - mb_strlen($truncateString));
            if ($truncateLastspace) {
                $text = preg_replace('/\s+?(\S+)?$/', '', $text);
            }
        $text = $text.$truncateString;
        }
        return $text;
    } // END-truncate

  
    /***
     * Retorna una cadena con cada palabra en su primera letra en mayusculas y el resto en minúsculas.
     * 
     */
    static function nombrePersona(string $string): string {
        return ucwords(mb_strtolower(OdaUtils::sanearString($string), 'UTF-8'));
    } // END-nombrePersona

    static function functionNames(string $string): string {
      $arr = str_split(str_replace('_', '', $string));
      $new_string = '';
      foreach ($arr as $letra) {
        $new_string .= (($letra==strtoupper($letra)) ? ' '.$letra : $letra);
      }
      return self::nombrePersona($new_string);
    } // END-nombrePersona
  
  /***
   * Retorna una cadena limpia de caracteres no deseados
   */
  static function sanearString($string) {
    $string = trim($string);
    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
 
    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
 
    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
 
    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
 
    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ç', 'Ç'),
        array('c', 'C'),
        $string
    );
 
    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("¨", "º", "-", "~",
             "#", "@", "|", "!", '"',
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             "."),
        '',
        $string
    );

    return $string;
  }



    /*
     * Metodo para obtener la ip real del cliente
     */
    public static function getIp() {
        return (isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : (isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR']));

        // if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
        //     $client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : "unknown" );
        //     $entries = explode('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);
        //     reset($entries);
        //     while (list(, $entry) = each($entries)) {
        //         $entry = trim($entry);
        //         if ( preg_match("/^([0-9]+\\.[0-9]+\\.[0-9]+\\.[0-9]+)/", $entry, $ip_list) ) {
        //             $private_ip = array('/^0\\./', '/^127\\.0\\.0\\.1/', '/^192\\.168\\..*/', '/^172\\.((1[6-9])|(2[0-9])|(3[0-1]))\\..*/', '/^10\\..*/');
        //             $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);
        //             if ($client_ip != $found_ip) {
        //                 $client_ip = $found_ip;
        //                 break;
        //             }
        //         }
        //     }
        // } else {
        //     $client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ? $_SERVER['REMOTE_ADDR'] : ( ( !empty($_ENV['REMOTE_ADDR']) ) ? $_ENV['REMOTE_ADDR'] : "unknown" );
        // }
        // return $client_ip;
    }

    //=============
    static function isLocalhost() {
      return
            $_SERVER["HTTP_HOST"] === "127.0.0.1"
            || $_SERVER["HTTP_HOST"] === "localhost"
            || strncmp($_SERVER["HTTP_HOST"], "192.168.", 8) === 0;
    } // END-isLocalhost

    /*
     * Metodo para resaltar palabras de una cadena de texto
     */
    public static function resaltar(string $palabra, string $texto) {
        $reemp  =   str_ireplace($palabra,'%s',$texto);
        $aux    =   $reemp;
        $veces  =   substr_count($reemp,'%s');
        if($veces == 0) {
            return $texto;
        }
        $palabras_originales    =   array();
        for($i = 0 ; $i < $veces ; $i ++) {
            $palabras_originales[] = '<b style="color: red;">'.substr($texto,strpos($aux,'%s'),strlen($palabra)).'</b>';
            $aux = substr($aux,0,strpos($aux,'%s')).$palabra.substr($aux,strlen(substr($aux,0,strpos($aux,'%s')))+2);
        }
        return vsprintf($reemp,$palabras_originales);
    }

    /**
     * Metodo para crear el slug de cadenas de string dadas
     */
    public static function getSlug(
        string $string, 
        string $separator = '-', 
        int $length = 100,
    ): string {
        $search = explode(',', 'ç,Ç,ñ,Ñ,æ,Æ,œ,á,Á,é,É,í,Í,ó,Ó,ú,Ú,à,À,è,È,ì,Ì,ò,Ò,ù,Ù,ä,ë,ï,Ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,Š,Œ,Ž,š,¥');
        $replace = explode(',', 'c,C,n,N,ae,AE,oe,a,A,e,E,i,I,o,O,u,U,a,A,e,E,i,I,o,O,u,U,ae,e,i,I,oe,ue,y,a,e,i,o,u,a,e,i,o,u,s,o,z,s,Y');
        $string = str_replace($search, $replace, $string);
        $string = strtolower($string);
        $string = preg_replace('/[^a-z0-9_]/i', $separator, $string);
        $string = preg_replace('/\\' . $separator . '[\\' . $separator . ']*/', $separator, $string);
        if (strlen($string) > $length) {
            $string = substr($string, 0, $length);
        }
        $string = preg_replace('/\\' . $separator . '$/', '', $string);
        $string = preg_replace('/^\\' . $separator . '/', '', $string);
        return $string;
    }

    /**
     * Método para ordenar un array de datos
     *
     * @param array $toOrderArray Array de datos
     * @param string $field Campo del array por el cual se va a ordenar
     * @param string $type Variable para indicar si ordena ASC o DESC
     * @return array
     */
    public static function orderArray(
        array $toOrderArray, 
        string|int $field, 
        string $type='DESC'
    ): array {
        $position = array();
        $newRow = array();
        foreach ($toOrderArray as $key => $row) {
            $position[$key]  = $row[$field];
            $newRow[$key] = $row;
        }
        if ($type=='DESC') {
            arsort($position);
        } else {
            asort($position);
        }
        $returnArray = array();
        foreach ($position as $key => $pos) {
            $returnArray[] = $newRow[$key];
        }
        return $returnArray;
    }
    
    /**
     * Devuelve el plural de un texto
     */
    public static function pluralize(string $cadena): string {
      if (str_ends_with($cadena, 'es')) { return $cadena; }
      if (str_ends_with($cadena, 's'))  { return $cadena; }
      return $cadena.'s';
    } // END-pluralize

    
    /**
     * Devuelve el singular de un texto
     */
    public static function singularize(string $cadena): string {
      $excepciones = ['estudiantes'=>'estudiante'];
      if (array_key_exists($cadena, $excepciones)) {
        return $excepciones[$cadena];
      }
      if (str_ends_with($cadena, 'es')) { return substr($cadena, 0, strlen($cadena)-2); }
      if (str_ends_with($cadena, 's'))  { return substr($cadena, 0, strlen($cadena)-1); }
      return $cadena;
    } // END-pluralize


    /**
     * Escribe en letras un monto numerico
     *
     * @param numeric $valor
     * @param string $moneda
     * @param string $centavos
     * @return string
     */
    public static function getNumeroALetras(
        int $valor=0, 
        string $moneda='PESOS', 
        int $centavos=0
    ): string {
        $a = $valor;
        $p = $moneda;
        $c = $centavos;
        $val = "";
        $v = $a;
        $a = (int) $a;
        $d = round($v - $a, 2);
        if($a>=1000000){
            $val = millones($a - ($a % 1000000));
            $a = $a % 1000000;
        }
        if($a>=1000){
            $val.= miles($a - ($a % 1000));
            $a = $a % 1000;
        }
        $val.= trim(value_num($a))." $p ";
        if($d){
            $d*=100;
            $val.= "CON ".value_num($d)." $c ";
        }
        return $val;
    }

}




/**
 * Las siguientes funciones son utilizadas para la generación
 * de versiones escritas de numeros
 *
 * @param numeric $a
 * @return string
 */
function value_num($a=1){
    if($a<=21){
        switch ($a){
            case 1: return 'UNO';
            case 2: return 'DOS';
            case 3: return 'TRES';
            case 4: return 'CUATRO';
            case 5: return 'CINCO';
            case 6: return 'SEIS';
            case 7: return 'SIETE';
            case 8: return 'OCHO';
            case 9: return 'NUEVE';
            case 10: return 'DIEZ';
            case 11: return 'ONCE';
            case 12: return 'DOCE';
            case 13: return 'TRECE';
            case 14: return 'CATORCE';
            case 15: return 'QUINCE';
            case 16: return 'DIECISEIS';
            case 17: return 'DIECISIETE';
            case 18: return 'DIECIOCHO';
            case 19: return 'DIECINUEVE';
            case 20: return 'VEINTE';
            case 21: return 'VEINTIUN';
        }
    } else {
        if($a<=99){
            if($a>=22&&$a<=29) {
                return "VENTI".value_num($a % 10);
            }
            if($a==30) {
                return  "TREINTA";
            }
            if($a>=31&&$a<=39) {
                return "TREINTA Y ".value_num($a % 10);
            }
            if($a==40) {
                $b = "CUARENTA";
            }
            if($a>=41&&$a<=49) {
                return "CUARENTA Y ".value_num($a % 10);
            }
            if($a==50) {
                return "CINCUENTA";
            }
            if($a>=51&&$a<=59) {
                return "CINCUENTA Y ".value_num($a % 10);
            }
            if($a==60) {
                return "SESENTA";
            }
            if($a>=61&&$a<=69) {
                return "SESENTA Y ".value_num($a % 10);
            }
            if($a==70) {
                return "SETENTA";
            }
            if($a>=71&&$a<=79) {
                return "SETENTA Y ".value_num($a % 10);
            }
            if($a==80) {
                return "OCHENTA";
            }
            if($a>=81&&$a<=89) {
                return "OCHENTA Y ".value_num($a % 10);
            }
            if($a==90) {
                return "NOVENTA";
            }
            if($a>=91&&$a<=99) {
                return "NOVENTA Y ".value_num($a % 10);
            }
        } else {
            if($a==100) {
                return "CIEN";
            }
            if($a>=101&&$a<=199) {
                return "CIENTO ".value_num($a % 100);
            }
            if($a>=200&&$a<=299) {
                return "DOSCIENTOS ".value_num($a % 100);
            }
            if($a>=300&&$a<=399) {
                return "TRECIENTOS ".value_num($a % 100);
            }
            if($a>=400&&$a<=499) {
                return "CUATROCIENTOS ".value_num($a % 100);
            }
            if($a>=500&&$a<=599) {
                return "QUINIENTOS ".value_num($a % 100);
            }
            if($a>=600&&$a<=699) {
                return "SEICIENTOS ".value_num($a % 100);
            }
            if($a>=700&&$a<=799) {
                return "SETECIENTOS ".value_num($a % 100);
            }
            if($a>=800&&$a<=899) {
                return "OCHOCIENTOS ".value_num($a % 100);
            }
            if($a>=901&&$a<=999) {
                return "NOVECIENTOS ".value_num($a % 100);
            }
        }
    }
}
/**
 * Genera una cadena de millones
 *
 * @param numeric $a
 * @return string
 */
function millones($a=1) {
    $a = $a / 1000000;
    if($a==1) {
        return "UN MILLON ";
    } else {
        return value_num($a)." MILLONES ";
    }
}

/**
 * Genera una cadena de miles
 *
 * @param numeric $a
 * @return string
 */
function miles($a=1){
    $a = $a / 1000;
    if($a==1) {
	return "MIL";
    } else {
	return value_num($a)." MIL ";
    }
}


?>
