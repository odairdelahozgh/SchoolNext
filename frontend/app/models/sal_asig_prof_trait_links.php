<?php

trait SalAsigProfTraitLinks {

  public function getLnkPageIndicadores(int $grado_id): string {
    return OdaTags::link("docentes/listIndicadores/$grado_id/$this->asignatura_id", 'Indicadores');
  } //END-getLnkPageIndicadores

  public function getLnkPageListNotas(): string {
    return OdaTags::link("docentes/listNotas/$this->asignatura_id/$this->salon_id", 'Notas');
  } //END-getLnkPageListNotas

  
  public function getAsignaturaF(int $user_id, string $asignatura_nombre, string $profesor_nombre): string {
    return OdaUtils::sanearString($asignatura_nombre).' '.(($user_id==1)?"[$this->asignatura_id]":'')
            .(($user_id==1) ? "<br> [$profesor_nombre] ($user_id)" :'');
  } //END-getLnkPageIndicadores

  
  public function getSalonF(int $user_id, string $salon_nombre): string {
    return $salon_nombre.' '.(($user_id==1)?"[$this->salon_id]":'');
  } //END-getLnkPageIndicadores
  

} //END-Trait