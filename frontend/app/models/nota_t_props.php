<?php

trait NotaTProps {
    public function getfoto() { return IMG_UPLOAD_PATH.'/estudiantes/'.$this->id.'.png'; }
}