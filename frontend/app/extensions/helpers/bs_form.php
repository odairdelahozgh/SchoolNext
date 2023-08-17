<?php
/**
 * Helper para Formularios Boostrap.
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source   frontend\app\extensions\helpers\bsform.php
 */

class BsForm extends Form {
  
  private string $_form_name = '';

  const METHOD = [
    'POST' => 'post',
    'GET'  => "get",
 ];

  public function __construct(
    private object $_modelo, 
    private string $_action, 
    private string $_method = self::METHOD['POST'], 
    private bool   $_multipart=false) {
    $this->_form_name   = strtolower(OdaUtils::pluralize($_modelo::class));
 } // END-__construct

  public function getInput(string|bool $tipo=null, string $field='', $attrs=''): string {
    $fieldname    = $this->_form_name.'.'.trim($field);
    $place_holder =  $this->getAttrib($field). ' '. $this->getPlaceholder($field);
    $label        = $this->getLabel($field);
    // $help         = $this->getHelp($field);
    // $value      = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);
    $widget     = (is_null($tipo)) ? $this->getWidget($field) : $tipo;
    // $campo_input = $this::input($widget, $fieldname, $attr, $value);
    // $this->_ffields[$columna] .= ($tipo=='hidden') ? $campo_input : "<br><label> $label" .$campo_input .$help ."</label>";
    
    $input = Form::input(
      type:  $widget, 
      field: $fieldname, 
      attrs: $attrs .$place_holder
    );

    return "
      <div class=\"form-label-group\">
        $input
        <label for=\"$fieldname\">$label</label>
        <div class=\"invalid-feedback\"> $label es requerido. </div>
      </div>
    ";
  } //END-getInput

  private function getPlaceholder($field) {
    return (($this->_modelo->getPlaceholder($field)) ? " placeholder=\"{$this->_modelo->getPlaceholder($field)}\" " : '');
  } // END-getPlaceholder

  private function getLabel($field) {
    return $this->_modelo->getLabel($field);
  } // END-getLabel

  private function getAttrib($field) {
     return (($this->_modelo->getAttrib($field)) ? ' '.$this->_modelo->getAttrib($field).' ' : '') ;
  } // END-getAttrib

  private function getWidget($field) {
   return (($this->_modelo->getWidget($field)) ? $this->_modelo->getWidget($field) : 'input') ;
 } // END-getWidget

} // END-Class