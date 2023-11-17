<?php

trait SalAsigProfTraitProps {

  public function __toString() { return $this->salon_id.'-'.$this->asignatura_id .'-' .$this->user_id ; }

} //END-Trait