<?php

require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;


//Respect Validation
// https://respect-validation.readthedocs.io/en/latest/
// tutorial: https://www.sitepoint.com/validating-your-data-with-respect-validation/

class OdaValid
{
  
  
  public static function validar_todo($valor) {
    $emailValidator = \Respect\Validation\Validator::email();
    $numericValidator = \Respect\Validation\Validator::numericVal();

    echo $emailValidator->validate($valor) ? 'Es un email' : 'No es Email';
    echo '<br>'.($numericValidator->validate($valor) ? 'Es numérico' : 'No es numérico');

  }

  public static function usernameValid($username){
    $regla = validar::alnum()->noWhitespace()->length(1, 15);
    echo '<br>'.($regla->validate($username) ? 'Username Valido' : 'Username NO Valido');
  }

} // END-OdaValid
