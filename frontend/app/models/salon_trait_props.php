<?php

trait SalonTraitProps {
 
  public function __toString() { return $this->nombre; } 

  public function isDirector(int $user_id): bool { 
    return (false !== ( (new Salon)::first('Select t.id from sweb_salones as t where t.director_id=? or t.codirector_id=?', [$user_id, $user_id]) ) );
  } //END-isDirector
  
  public function getImgFirmaDirector(string $attrs="style=\"width:100%;max-width:180px\""): string { 
    $Director = (new Usuario)::get($this->director_id);
    $filename = $Director->documento."_firma.png";
    return OdaTags::img(src: "upload/users/$filename", alt: 'firma', attrs: $attrs , err_message: "");
  }

  public function getNombreDirector(): string { 
    return (new Usuario)::get($this->director_id);
  }

} //END-Trait