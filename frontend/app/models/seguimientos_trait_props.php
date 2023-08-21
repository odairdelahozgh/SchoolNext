<?php
/**
 * Summary of SeguimientosTraitProps
 */
trait SeguimientosTraitProps {

  private static $asi_valido = 2;

  public function fieldForm(string $field_name, string $attr='', string|bool $type=null, bool $label=false): string {
    try {
      $label = ($label) ? $this->getLabel($field_name).'<br>':'';
      $attribs = ($attr) ? $attr : $this->getAttrib($field_name);


      if ('textarea'==$this->getWidget($field_name)) {
        return $label.Form::textarea(
          field: 'seguimientos.'.$field_name.'_'.$this->id, 
          attrs: $attribs . $this->getPlaceholder($field_name),
          value: $this->$field_name,
        );

      } else {
        if ('asi_desempeno'==$field_name) {
          return $label.Form::select(
            field: 'seguimientos.'.$field_name.'_'.$this->id, 
            data: ['Bajo'=>'Bajo', 'Básico'=>'Básico', 'Básico +'=>'Básico +'],
            value: $this->$field_name,
          );
        } else {
          return  $label.Form::input(
            type:  ((!is_null($type)) ? $type : $this->getWidget($field_name)),
            field: 'seguimientos.'.$field_name.'_'.$this->id, 
            attrs: $attribs . $this->getPlaceholder($field_name),
            value: $this->$field_name,
          );
        }        
      }
      

      $campo_valor = '<span '. (('hidden'==$type) ? 'class="w3-hide"' : '') .'">'.(string)$this->$field_name.'</span>';
      return $campo_valor;
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }//END-fieldForm


} //END-Trait