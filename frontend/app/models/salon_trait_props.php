<?php

trait SalonTraitProps {

  /*
  */ 
  public function __toString() { return $this->nombre; }
  
  /*
   * Saber si un usuario es director del salón en cuestión.
   */ 

/*   public function getNombreDirector() { 
    $registro = $this::first("SELECT * FROM dm_user WHERE id = :usuario", [":usuario" => $this->director_id]);
    if (!$registro) {
      return false;
    }
    return true;
  } */

  /* 
  public function esDirector(int $user_id) { 
    $registro = $this::first("SELECT * FROM self::$table WHERE director_id = :usuario", [":usuario" => $user_id]);
    if (!$registro) {
      return false;
    }
    return true;
  } */
  
} //END-TraitProps