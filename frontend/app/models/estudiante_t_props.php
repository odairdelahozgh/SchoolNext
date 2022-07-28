<?php

trait EstudianteTProps {

    protected static $default_foto_estud = '';
    protected static $default_foto_estud_circle = '';

    public function __toString() { return $this->getNombreCompleto(); }
    public function getCodigo() { return '[Cod: '.$this->id.']'; }
    public function getApellidos() { return $this->apellido1.' '.$this->apellido2; }    
    public function getNombreCompleto($orden='a1 a2, n') {
        return str_replace(
          array('n', 'a1', 'a2'),
          array($this->nombres, $this->apellido1, $this->apellido2),
          $orden
      );
    }
    public function getIsActiveF() { return (($this->is_active) ? _Icons::solid('face-smile', 'w3-small') : _Icons::solid('face-frown', 'w3-small') ); }
    public function isPazYSalvo() {
        $periodo = Config::get('academico.periodo_actual');
        if ($periodo==1 and $this->mes_pagado>=4) { return true; }
        if ($periodo==2 and $this->mes_pagado>=6) { return true; }
        if ($periodo==3 and $this->mes_pagado>=8) { return true; }
        if ($periodo==4 and $this->mes_pagado>=11 and !$this->is_debe_preicfes and !$this->is_debe_almuerzos) { return true; }
        if ($periodo==5 and $this->mes_pagado>=11 and !$this->is_debe_preicfes and !$this->is_debe_almuerzos) { return true; }
        return false;
    }
    public function isPazYSalvoIco() { return ($this->isPazYSalvo()) ? _Icons::solid('face-smile', 'w3-small') : _Icons::solid('face-frown', 'w3-small'); }
    public function getCuentaInstit() { return ($this->email_instit) ? $this->email_instit.'@'.Config::get('institucion.dominio').' '.$this->clave_instit : ''; }
    
    public function getFoto($max_width=80) { return _Tag::img("upload/estudiantes/$this->id.png",$this->id, "class=\"w3-round\" style=\"width:100%;max-width:$max_width px\"", self::$default_foto_estud); }
    public function getFotoCircle($max_width=80) { return _Tag::img("upload/estudiantes/$this->id.png",$this->id, "class=\"w3-circle w3-bar-item\" style=\"width:100%;max-width:$max_width px\"", self::$default_foto_estud_circle); }


    public function linkOld_BoletinPeriodo() {
        $estud_id = $this->id;
        $salon_id = $this->salon_id;
        $url = Config::get('old.url_schoolweb');
        $periodo_actual = Config::get('academico.periodo_actual');
        $btns = '';
        for ($i=1; $i<=$periodo_actual; $i++) { 
            $href="$url/+/coordinacion/GenerarBoletines?salon_id=$salon_id&amp;periodo=$i&amp;estudiante_id=$estud_id&amp;ver_nota=1\"";
            $txt="P$i";
            $attrs="class=\"w3-btn w3-round w3-padding-small w3-red\" target=\"_blank\" title=\"Descargar Boletín : Periodo $i\"";
            $btns .= _Tag::linkExterno($href, $txt, $attrs).'&ensp;';
        }
        return '<div class="w3-show-inline-block"><div class="w3-bar">'.$btns.'</div></div>';
    }
}