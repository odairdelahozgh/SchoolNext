<?php
trait EmpleadoTraitProps {

  protected static $default_foto_estud = '';
  protected static $default_foto_estud_circle = '';

  public function __toString() { return $this->getNombreCompleto(sanear:true, mayuscula:false).' '.$this->getCodigo().' '.$this->isNuevo(); }
  public function getCodigo() { return '['.$this->documento.']'; }
  public function getApellidos() { return $this->apellido1.' '.$this->apellido2; }

  public function getNombreCompleto($orden='a1 a2, n', $sanear=true, $mayuscula=false) {
    $nombre_completo = str_replace(
      array('n', 'a1', 'a2'),
      array( $this->nombres, $this->apellido1, $this->apellido2),
      $orden
    );
    if ($sanear) { $nombre_completo = OdaUtils::sanearString($nombre_completo);  }
    $nombre_completo = mb_convert_case($nombre_completo, MB_CASE_TITLE, "UTF-8");
    if ($mayuscula) { $nombre_completo = strtoupper($nombre_completo); }
    return $nombre_completo;
  } //getNombreCompleto

  public function getCuentaInstit($show_ico=false) { 
    $ico = ($show_ico) ? OdaTags::img(src:'msteams_logo.svg', attrs:'width="16"', err_message:'').' ' : '' ;
    return $ico.(($this->usuario_instit) ? $this->usuario_instit.'@'.Config::get('config.institution.dominio').'<br>Clave: '.$this->clave_instit : 'No tiene usuario en plataforma'); 
  }
  
    
  public static function getFotoEmpleado(int $documento, int $max_width=80, string $class='w3-round', bool $show_cod=true) { 
    return Usuario::getFotoUser(id: $documento, max_width: $max_width, class: $class, show_cod: $show_cod);
  } //END-getFotoEmpleado
  
  
  public function getFoto(int $max_width=80, bool $show_cod=true) { return self::getFotoEmpleado(documento: $this->documento, show_cod: $show_cod); }
  
  public function getFotoCircle(int $max_width=80, bool $show_cod=true) { return self::getFotoEmpleado(documento: $this->documento, class: 'w3-circle', show_cod: $show_cod); }
  

  public function isNuevo() { 
    $fecha_lim = (string)(Date('Y')-1).'-10-01';
    return ( (substr($this->created_at, 0,10)>=$fecha_lim ) ? true : false);
  }
  public function is_nuevo_ico() { return ( $this->isNuevo() ? '<span class="w3-text-red">NEW</span>' : '' ); }
  
  public function is_active_f(bool $show_ico=false, string $attr="w3-small"): string {
    $estado = self::IS_ACTIVE[(int)$this->is_active] ?? 'Inactivo';
    $ico    = '';
    if ($show_ico) {
      $ico = match((int)$this->is_active) {
        0   => '<span class="w3-text-red">'._Icons::solid(self::ICO_IS_ACTIVE[0], $attr).'</span> ',
        1   => '<span class="w3-text-green">'._Icons::solid(self::ICO_IS_ACTIVE[1], $attr).'</span> '
      };
    }
    return $ico.$estado;
  }


} //END-TraitProps