<?php
trait EstudianteTraitProps {

  protected static $default_foto_estud = 'upload/estudiantes/user.png';
  protected static $default_foto_estud_f = 'upload/estudiantes/user_f.png';
  protected static $default_foto_estud_m = 'upload/estudiantes/user_m.png';

  public function __toString() { return $this->getNombreCompleto(sanear:true, mayuscula:false).' '.$this->getCodigo(); }
  public function getCodigo() { return '[Cod: '.$this->id.']'; }
  public function getApellidos() { return $this->apellido1.' '.$this->apellido2; }
  public function getNombre() { return $this->nombres.' '.$this->apellido1.' '.$this->apellido2; }
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

  public function isPazYSalvo(): bool {
    $periodo = (int)Config::get(var: 'config.academic.periodo_actual');
    $annio = (int)Config::get(var: 'config.academic.annio_actual');
    // cambiar por match expres
    if ($periodo==1 and $this->mes_pagado>=parent::LIM_PAGO_PERIODOS[1] and $this->annio_pagado==$annio)  { return true; }
    if ($periodo==2 and $this->mes_pagado>=parent::LIM_PAGO_PERIODOS[2] and $this->annio_pagado==$annio) { return true; }
    if ($periodo==3 and $this->mes_pagado>=parent::LIM_PAGO_PERIODOS[3] and $this->annio_pagado==$annio) { return true; }
    if ($periodo==4 and $this->mes_pagado>=parent::LIM_PAGO_PERIODOS[4] and $this->annio_pagado==$annio and !$this->is_debe_preicfes and !$this->is_debe_almuerzos) { return true; }
    if ($periodo==5 and $this->mes_pagado>=parent::LIM_PAGO_PERIODOS[5] and $this->annio_pagado==$annio and !$this->is_debe_preicfes and !$this->is_debe_almuerzos) { return true; }
    return false;
  }
  public function isPazYSalvoIco() { 
    $result = ($this->isPazYSalvo()) ? ' <span class="w3-text-green">'._Icons::solid('coins', 'w3-large').'</span>' : ' <span class="w3-text-red">'._Icons::solid('coins', 'w3-large').'</span>'; 
    return $result;
  }
  public function getCuentaInstit($show_ico=false) { 
    $ico = ($show_ico) ? OdaTags::img(src:'msteams_logo.svg', attrs:'width="16"', err_message:'').' ' : 'MS Teams: ' ;
    return $ico.(($this->email_instit) ? $this->email_instit.'@'.Config::get('config.institution.dominio').' '.$this->clave_instit : 'No tiene usuario en MS TEAMS'); 
  }
  

  public static function getFotoEstud(int $id, int $max_width=80, string $class='w3-round', bool $show_cod=true, string $sexo='m'): string { 
    $cod_id  = ($show_cod) ? 'est-'.$id.'<br>' : '' ;
    
    $img_default = match(strtolower(substr(trim($sexo),0,1))) {
      'm'  => self::$default_foto_estud_m,
      'f'  => self::$default_foto_estud_f,
      default => self::$default_foto_estud,
    };
    $foto_default = OdaTags::img(
        src:          $img_default, 
        alt:          $id,
        attrs:        "class=\"$class\" width:\"{$max_width}\"",
        err_message:  'no image'
    );

    return $cod_id .OdaTags::img(
      src: "upload/estudiantes/$id.png", 
      alt: $id, 
      attrs: "class=\"$class\" width=\"{$max_width}\"",
      err_message: $foto_default
    );
  } //END-getFotoEstud


  public function getFoto(int $max_width=80, bool $show_cod=false) { 
    return self::getFotoEstud($this->id, $max_width, 'w3-round', $show_cod, $this->sexo);
  } //END-getFoto


  public function getFotoCircle(int $max_width=80, bool $show_cod=true) { 
    return self::getFotoEstud($this->id, $max_width, 'w3-circle', $show_cod, $this->sexo);
  } //END-getFotoCircle


  public function isNuevo() { 
    $fecha_lim = (string)(Date('Y')-1).'-10-01';
    return ( (substr($this->created_at, 0,10)>=$fecha_lim ) ? true : false);
  }
  public function isNuevoIco() { return ( $this->isNuevo() ? '<span class="w3-text-red">NEW</span>' : '' ); }
  public function getPagoPension() { return 'Pago Pensión: '.OdaUtils::nombreMes((int)$this->mes_pagado).' de '.$this->annio_pagado; }
  public function getDebePreicfes() { return 'Debe Preicfes: '.(($this->is_debe_preicfes) ? 'SI' : 'NO'); }
  public function getDebeAlmuerzos() { return 'Debe Almuerzos: '.(($this->is_debe_almuerzos) ? 'SI' : 'NO'); }

} //END-TraitProps