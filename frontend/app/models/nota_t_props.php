<?php

trait NotaTProps {
    public function __toString() { return $this->id; }
    public function getIsActiveF() { return (($this->is_active) ? _Icons::solid('face-smile', 'w3-small') : _Icons::solid('face-frown', 'w3-small') ); }
    public function getfoto() { return IMG_UPLOAD_PATH.'/estudiantes/'.$this->id.'.png'; }
}