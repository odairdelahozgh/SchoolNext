<?php

trait Base {

  public function generateClasses(): string {
    $classes = "$this->idcomp $this->idcomp-".$this->color->value;

    if (!empty($this->size)) {
        $classes .= " {$this->idcomp}-" . $this->size->value;
    }

    if (!empty($this->additionalClasses)) {
        $classes .= ' ' . $this->additionalClasses;
    }

    return $classes;
  }


}