<?php
trait GradoTraitLinks {

  
  public function linkEdit() {
    return Js::link(action: "admin/grado/edit/$this->id", 
                text: _Icons::solid('square-pen'), 
                attrs: 'title="Editar Registro"');
  }


  public function linkEditUuid() {
    return Js::link(action: "admin/grado/editUuid/$this->id", 
                text: _Icons::solid('square-pen'), 
                attrs: 'title="Editar Registro"');
  }

  public function linkDelete() {
    return Js::link(action: "admin/grado/del/$this->id", 
                text: _Icons::solid('trash-can'), 
                confirm: "Atención: ¿Quiere eliminar: $this->nombre?", 
                attrs: 'title="Eliminar Registro"');
  }

  public function linkDeleteUuid() {
    return Js::link(action: "admin/grado/delUuid/$this->uuid", 
                text: _Icons::solid('trash-can'), 
                confirm: "Atención: ¿Quiere eliminar: $this->nombre?", 
                attrs: 'title="Eliminar Registro"');
  }


} //END-TraitLinks