<?php

trait SeccionTraitProps {
 
  public function __toString() { return $this->nombre; } 

  public static function segSecPrescolar(): array { 
    return [1]; 
  }

  public static function segSecPrimaria(): array { 
    return [2]; 
  }
  
  public static function segSecBachillerato(): array { 
    return [3, 4]; 
  }
} //END-Trait