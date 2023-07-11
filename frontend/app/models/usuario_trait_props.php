<?php
trait UsuarioTraitProps {

  protected static $default_foto_usuario = 'upload/users/user.png';

  public function __toString() {
    return $this->getNombreCompleto('a1 a2 n');
  }
  

  public static function getFotoUser(int $id, int $max_width=80, string $class='w3-round', bool $show_cod=true): string { 
    $cod_id  = ($show_cod) ? $id.'<br>' : '' ;
    $foto_default = OdaTags::img(
        src:          self::$default_foto_usuario, 
        alt:          $id,
        attrs:        "class=\"$class\" style=\"width:100%;max-width:".$max_width."px\"",
        err_message:  'no image'
    );

    return $cod_id .OdaTags::img(
      src: "upload/users/$id.png", 
      alt: $id, 
      attrs: "class=\"$class\" style=\"width:100%;max-width:".$max_width."px\"",
      err_message: $foto_default
    );
  } //END-getFotoUser

  
  public function getFoto(int $max_width=80, bool $show_cod=true) { 
    return self::getFotoUser($this->documento, $max_width, 'w3-round', $show_cod);
  } //END-getFoto


  public function getFotoCircle(int $max_width=80, bool $show_cod=true) { 
    return self::getFotoUser($this->documento, $max_width, 'w3-circle', $show_cod);
  } //END-getFotoCircle


  /*
   * Devuelve una composición del nombre completo del usuario
   */
  public function getNombreCompleto2($orden='a1 a2, n', $sanear=true, $humanize=false) {
    if ($sanear) {
      $this->nombres   = OdaUtils::sanearString($this->nombres);
      $this->apellido1 = OdaUtils::sanearString($this->apellido1);
      $this->apellido2 = OdaUtils::sanearString($this->apellido2);
    }
    
    if ($humanize) {
      $this->nombres   = OdaUtils::nombrePersona($this->nombres);
      $this->apellido1 = OdaUtils::nombrePersona($this->apellido1);
      $this->apellido2 = OdaUtils::nombrePersona($this->apellido2);
    }
        
    return str_replace( array('n', 'a1', 'a2'),
            array($this->nombres, $this->apellido1, $this->apellido2), $orden);
    }

  /*
   * Devuelve una composición del nombre completo del usuario
   */
  public function getNombreCompleto($orden='a1 a2, n'): array|string {
    return str_replace( array('n', 'a1', 'a2'),
            array($this->nombres, $this->apellido1, $this->apellido2), $orden);
  }

  
} //END-TraitProps