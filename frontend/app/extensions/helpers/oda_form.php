<?php
/**
 * Helper para Formularios Odair.
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source   frontend\app\extensions\helpers\oda_form.php
 */
class OdaForm extends Form {
   private $version = '2023.12.14';
   private $_style = ' class="w3-input w3-border" ';
   private $_modelo = '';
   private $_fname   = '';
   private $_faction = '';
   private $_fmethod = '';
   private $_fattrs = '';
   private $_fhiddens = '';
   private $_ffields = array(1=>' ', 2=>' ');
   private $_isEdit = false;
   private $_isMultipart = false;
   private $_fields_in_form = [];
   const ICO_SEARCH = '<i class="fa-solid fa-search w3-large"></i>';
   const ICO_SEARCH_SMALL = '<i class="fa-solid fa-search w3-small"></i>';

   const METHOD = [
      'POST' => 'post',
      'GET'  => "get",
   ];

  /**
   * @example echo $myForm = new OdaForm('Grado', 'admin/grados/create', 2);
   * @source  frontend\app\extensions\helpers\odaodaform.php
   */
  public function __construct(object $modelo, string $action, string $method = self::METHOD['POST'], $cols=1, bool $multipart=false) {
    $this->_modelo   = $modelo;
    $this->_fname    = strtolower(OdaUtils::pluralize($modelo::class));
    $this->_faction  = $action;
    $this->_fmethod  = $method;
    $this->_ffields  = match ($cols) {
        1 => [1=>' '],
        2 => [1=>' ', 2=>' '],
        3 => [1=>' ', 2=>' ', 3=>' '],
        default => [1=>' '],
    };
    $this->_isMultipart = $multipart;
  } // END-function

  public function __toString(): string {
    $cols_max = array_key_last($this->_ffields);
    $data_sets = '';
    if ($cols_max==2) {
      $fielset1   = self::createFieldset($this->_ffields[1], 'Columna 1', ' style="width:90%" ');
      $data_sets .= OdaTags::tag('div', $fielset1, 'class="w3-half w3-container"');
      $fielset2   = self::createFieldset($this->_ffields[2], 'Columna 2', ' style="width:90%" ');
      $data_sets .= OdaTags::tag('div', $fielset2, 'class="w3-half w3-container"');         
    } else {
      $fieldset   = self::createFieldset($this->_ffields[1], 'Registro', ' style="width:50%" ');
      $data_sets .= OdaTags::tag('div', $fieldset, 'class="w3-col w3-container"');
    }

    $form  = $this->getOpenForm();
    $form .= self::getHiddens();
    $form .= OdaTags::tag('div', $data_sets, 'class="w3-row"');
    $form .= '<br>' .$this->submit('Guardar'). ' ' .$this->reset('Cancelar', 'onclick="cancelar()"');
    $form .= self::close();
    return $form;
  } // END-function
  

  public function getFields(string $legend_fieldset): string { 
    return self::getHiddens().self::createFieldset($this->_ffields[1], $legend_fieldset); 
  } // END-function

   /**
    * Retorna un campos Input dependiendo del "tipo".
    * @example echo $myForm->addInput(2, 'number', 'cantidad', '1', 'w3-red');
    * @link    https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input 
    * week url time text tel submit search reset range radio password number month image hidden file email datetime-local date color checkbox button
    */
  public function addInput(string $field, int $columna=1, string|bool $tipo=null, string $attr='', bool $inline=false): void {
    $this->_fields_in_form[] = $field;
    $attr       = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
    $fieldname  = $this->_fname.'.'.trim($field);
    $label      = $this->getLabel($field, $inline);
    $help       = $this->getHelp($field);
    $value      = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);
    $widget     = (is_null($tipo)) ? $this->getWidget($field) : $tipo;

    $campo_input = $this::input($widget, $fieldname, $attr, $value);

    $this->_ffields[$columna] .= ($tipo=='hidden') ? $campo_input : "<br><label> $label" .$campo_input .$help ."</label>";
  } // END-function

  public function getInput(string $field, string|bool $tipo=null, string $attrs='', bool $inline=false): string {
    $this->_fields_in_form[] = $field;
    $attr = $this->_style . (($attrs) ? $attrs : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
    $fieldname    = $this->_fname.'.'.trim($field);
    $place_holder =  $this->getAttrib($field). ' '. $this->getPlaceholder($field);
    $label        = $this->getLabel($field, $inline);
    $help         = $this->getHelp($field);

    $value      = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);
    
    $widget     = (is_null($tipo)) ? $this->getWidget($field) : $tipo;
    $campo_input = $this::input($widget, $fieldname, $attr, $value);
    return ($tipo=='hidden') ? $campo_input : "<label> $label" .$campo_input .$help ."</label>";
  } // END-function

   /**
    * @link    https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file
    */
   public function addFile(string $field, int $columna=1, string $attr='', bool $inline=false): void {
    $this->_fields_in_form[] = $field;
    $attr       = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
    $fieldname  = trim($field);
    $label      = $this->getLabel($field, $inline);
    $help       = $this->getHelp($field);
    $campo_file  = $this::file($fieldname, $attr);
    $this->_ffields[$columna] .= "<br><label> $label" .$campo_file .$help ."</label>";
   } // END-function

   /**
    * Retorna un campos Input dependiendo del "tipo".
    * @example echo $myForm->addInput(2, 'number', 'cantidad', '1', 'w3-red');
    * @link    https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input 
    */
    public function addInput2(string $field, int $columna=1, string|bool $tipo=null, string $attr='', bool $inline=true): void {
      $this->_fields_in_form[] = $field;
      $attr       = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
      $fieldname  = $this->_fname.'.'.trim($field);
      $widget     = (is_null($tipo)) ? $this->getWidget($field) : $tipo;
      $label      = $this->getLabel($field, $inline);
      $value      = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);

      $campo_input = $this::input($widget, $fieldname, $attr, $value);
      $this->_ffields[(int)$columna] .= ($tipo=='hidden') ? $campo_input : "<label>$label" .$campo_input."</label>";
   } // END-function

   
   /**
    * Retorna un campos Texarea.
    * @example echo $myForm->addInput(2, 'number', 'cantidad', '1', 'w3-red');
    * @link    https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input 
    */
  public function addTextarea(string $field, int $columna=1, string $attr='', bool $inline=true): void {
    $this->_fields_in_form[] = $field;
    $attr       = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
    $fieldname  = $this->_fname.'.'.trim($field);
    $label      = $this->getLabel($field, $inline);
    $help       = $this->getHelp($field);
    $value      = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);

    $campo_textarea = $this::textarea($fieldname, $attr, $value);
    $this->_ffields[$columna] .= "<br><label>$label" .$campo_textarea .$help ."</label>";
  } // END-function
  
  public function getTextarea(string $field, string $attr='', $inline=true): string {
    $this->_fields_in_form[] = $field;
    $attr       = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
    $fieldname  = $this->_fname.'.'.trim($field);
    $label      = $this->getLabel($field, $inline);
    $help       = $this->getHelp($field);
    $value      = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);

    $campo_textarea = $this::textarea($fieldname, $attr, $value);
    return "<label>$label" .$campo_textarea .$help ."</label>";
  } // END-function

   /**
    * Retorna un campo Select.
    * @example $myForm->addSelect(2, 'seccion_id', '1', 'w3-red');
    */
  public function addSelect(string $field, int $columna=1, array $data=[], string $attr=''): void {
    $this->_fields_in_form[] = $field;
    $attr = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
    $fieldname  = trim($this->_fname.'.'.$field);
    $label       = $this->getLabel($field);
    $help        = $this->getHelp($field);
    $value = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field) ;

    $campo_select = $this::select($fieldname, $data, $attr, $value);
    $this->_ffields[(int)$columna] .= "<br><label> $label $campo_select $help </label>";
  } // END-addSelect

  public function getSelect(string $field, array $data=[], string $attr=''): string {
    $this->_fields_in_form[] = $field;
    $attr = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
    $fieldname = trim($this->_fname.'.'.$field);
    $label     = $this->getLabel($field);
    $help      = $this->getHelp($field);
    $value     = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field) ;

    $campo_select = $this::select($fieldname, $data, $attr, $value);
    return "<label> $label $campo_select $help </label>";
  } // END-addSelect

 
   
  /**
   * @link    https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/checkbox
   */
  public function addCheck(string $field, int $columna=1, string|array $attr=''): void {
    $this->_fields_in_form[] = $field;
    $fieldname  = trim($this->_fname.'.'.$field);
    $label = $this->getLabel($field);
    $help  = $this->getHelp($field);
    $value = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);
    $value = ($value) ? 1 : 0 ;
    $is_checked = ($value) ? true : false ;

    $check = Form::check($fieldname, $value, $attr, $is_checked).'<br>'.$help;
    $this->_ffields[(int)$columna] .= "<br><label> $label $check </label><br>";
  } // END-function

  public function getCheck(string $field, string|array $attr=''): string {
    $this->_fields_in_form[] = $field;
    $fieldname  = trim($this->_fname.'.'.$field);
    $label = $this->getLabel($field, true);
    $help  = $this->getHelp($field);
    $value = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);
    $value = ($value) ? 1 : 0 ;
    $is_checked = ($value) ? true : false ;

    $check = Form::check($fieldname, $value, $attr, $is_checked).'<br>'.$help;
    return "<label>$label $check</label><br>";
  } // END-function

  /**
   * @link    https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input 
   */
  public function addRadio(string $field, int $columna=1, string|array $attrs='', bool $checked=false): void {
    $this->_fields_in_form[] = $field;
    $value_defa = ($this->_isEdit) ? $this->_modelo->$field : 1;
    $help  = $this->getHelp($field);
      
    $radio_group = '<div class="w3-bar">';
    foreach ($this->getDefault($field) as $key_radio => $value_radio) {
      $checked = ($value_defa==$key_radio) ? true : false ;
      $radio_group .= "<div class=\"w3-bar-item\">$value_radio&nbsp;&nbsp;".Form::radio($field, $key_radio, $attrs, $checked).'</div>  ';
    }
    $radio_group .= '</div>'.$help;

    $label = $this->getLabel($field);
    $campo_radio = self::createFieldset($radio_group, $label);
    $this->_ffields[(int)$columna] .= '<br>'.$campo_radio;
  } // END-function

  public function setEdit(): void { 
    $this->_isEdit = true; 
  } // END-getDefault
  
  public function setColumnas(int $max_cols=1): void { 
    $this->_ffields  = array_fill(1, (int)$max_cols, ' '); 
  } // END-getDefault
  
  public function setAtrib(string|array $attrs = ''): void { 
    $this->_fattrs = Tag::getAttrs($attrs); 
  } // END-getDefault
  
  private function isRequired(string $field): bool { 
    return str_contains($this->_modelo->getAttrib($field), 'required'); 
  } // END-getDefault

  private function getDefault(string $field) { 
    return (($this->_modelo->getDefault($field)) ? $this->_modelo->getDefault($field) : ''); 
  } // END-getDefault

  public function getLabel(string $field, bool $inline=false): string {
    $requerido = ($this->isRequired($field)) ? '<i class="fa-solid fa-bolt"></i> ' : '' ;
    $in_line = ($inline) ? '' : '<br>' ;
    return (($this->_modelo->getLabel($field)) ? '<b>'.$requerido.$this->_modelo->getLabel($field).$in_line.'</b>' : OdaUtils::nombrePersona($field)) ;
  } // END-function

  public function getDataLabel(string $field, bool $inline=false): string {
    $in_line = ($inline) ? '' : '<br>' ;
    $label = (($this->_modelo->getLabel($field)) ? '<b>'.$this->_modelo->getLabel($field).$in_line.'</b>' : OdaUtils::nombrePersona($field)) ;
    $data = $this->_modelo->$field;
    return $label.$data;
  } // END-function

  private function getHelp(string $field): string { 
    return (($this->_modelo->getHelp($field)) ? '<i class="fa-solid fa-circle-info"></i> <small>'.$this->_modelo->getHelp($field).'</small>' : ''); 
  } // END-function

  private function getPlaceholder(string $field): string { 
    return (($this->_modelo->getPlaceholder($field)) ? ' placeholder="'.$this->_modelo->getPlaceholder($field).'" ' : '') ; 
  } // END-function

  private function getAttrib(string $field): string { 
    return (($this->_modelo->getAttrib($field)) ? ' '.$this->_modelo->getAttrib($field).' ' : ''); 
  } // END-function

  private function getWidget(string $field) { 
    return (($this->_modelo->getWidget($field)) ? $this->_modelo->getWidget($field) : 'input'); 
  } // END-function
  
  public function addHiddens(string $fields='id'): void { 
    $this->_fhiddens = str_replace(' ', '', $fields); 
  } // END-function

  public function getHiddens(): string {
    $result = '';
    foreach (explode(',',$this->_fhiddens) as $campo) {
      $value_input = ($this->_isEdit) ? $this->_modelo->$campo : $this->getDefault($campo) ;
      $result .= form::hidden($this->_fname.'.'.trim($campo), '', $value_input);
    }
    return $result;
  } // END-function

  /**
   * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/search
   */
  public static function inputSearch(string $input_search_id='inputSearch', string $table_id='mytable', string $placeholder="Filtrar"): string {
    $input = self::input(
      type: 'search', 
      field: $input_search_id, 
      attrs: "oninput=\"myFunctionFilter()\" class=\"w3-input w3-border\"  placeholder=\"$placeholder..\""
    );
    return  
       "<div class=\"w3-bar\">
          <div class=\"w3-bar-item\">".self::ICO_SEARCH."</div>
          <div class=\"w3-bar-item\">$input</div>
        </div>";
  } // END-function

  /**
   * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/fieldset
   **/
  private static function createFieldset(string $content, string $legend = '', $attrs = ''): string { 
    return "<fieldset $attrs> <legend>$legend</legend> $content </fieldset>"; 
  } // END-function

  public function getOpenForm(): string {
    if ($this->_isMultipart) { return self::openMultipart($this->_faction, $this->_fattrs); }
    return self::open($this->_faction, $this->_fmethod, $this->_fattrs);
  } //END-function
  
  public function getFieldsInForm(): array { 
    return $this->_fields_in_form; 
  } // END-function
  
  public function getFieldsNotInForm(string $tipo_form='edit'): array { 
    return array_diff($this->_modelo::getFieldsShow($tipo_form), $this->getFieldsInForm() ); 
  } // END-function

  public function v(): string {
    $version = \DateTime::createFromFormat(format: 'Y.m.d', datetime: $this->version);
    return 'PHP Helper OdaForm -> Version '.$version->format(format: 'd M Y');
  }//END-function

   
} // END-Class