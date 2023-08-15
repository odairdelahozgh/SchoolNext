<?php
/**
 * Helper para Formularios Boostrap.
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source   frontend\app\extensions\helpers\bsform.php
 */

class BsForm extends Form {
  
  private string $_form_name   = '';

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

  public function getInput(string $type='text', string $field='', $attrs=''): string {
    $fieldname  = $this->_form_name.'.'.trim($field);
    //$place_holder = $this->getPlaceholder($field);
    // $attr       = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
    // $label      = $this->getLabel($field, $inline);
    // $help       = $this->getHelp($field);
    // $value      = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);
    // $widget     = (is_null($tipo)) ? $this->getWidget($field) : $tipo;
    // $campo_input = $this::input($widget, $fieldname, $attr, $value);
    // $this->_ffields[$columna] .= ($tipo=='hidden') ? $campo_input : "<br><label> $label" .$campo_input .$help ."</label>";


    $input = Form::input(
      type:  $type, 
      field: $fieldname, 
      attrs: $attrs);
      
    return "
      <div class=\"form-label-group\">
        $input
        <label for=\"firstName\">First name</label>
        <div class=\"invalid-feedback\"> Valid first name is required. </div>
      </div>
    ";
  } //END-getInput

  private function getPlaceholder($field) {
    return (($this->_modelo->getPlaceholder($field)) ? " placeholder=\"$this->_modelo->getPlaceholder($field)\" " : '');
 } // END-getPlaceholder

} // END-Class