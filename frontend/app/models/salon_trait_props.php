<?php
/*
id, is_active, nombre, grado_id, director_id, codirector_id, position, tot_estudiantes,
print_state1, print_state2, print_state3, print_state4, print_state5, is_ready_print, print_state, 
created_by, created_at, updated_by, updated_at
*/
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