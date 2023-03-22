<?php
/**
 * Helper para Formularios Odair.
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source   frontend\app\extensions\helpers\odaodaform.php
 */
class OdaForm extends Form {
   private $version = '2023.02.01';
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
   } // END-__construct

   public function __toString(): string {
      $cols_max = array_key_last($this->_ffields);
      $data_sets = '';
      if ($cols_max==2) {
        $fielset1   = self::createFieldset($this->_ffields[1], 'Columna 1', ' style="width:90%" ');
        $data_sets .= self::createTag('div', $fielset1, 'class="w3-half w3-container"');
        $fielset2   = self::createFieldset($this->_ffields[2], 'Columna 2', ' style="width:90%" ');
        $data_sets .= self::createTag('div', $fielset2, 'class="w3-half w3-container"');         
      } else {
        $fieldset   = self::createFieldset($this->_ffields[1], 'Registro', ' style="width:50%" ');
        $data_sets .= self::createTag('div', $fieldset, 'class="w3-col w3-container"');
      }

      $form  = '';
      if ($this->_isMultipart) {
        $form .= self::openMultipart($this->_faction, $this->_fattrs);
      } else {
        $form .= self::open($this->_faction, $this->_fmethod, $this->_fattrs);
      }

      $form .= self::getHiddens();
      $form .= self::createTag('div', $data_sets, 'class="w3-row"');
      $form .= '<br>' .$this->submit('Guardar'). ' ' .$this->reset('Cancelar', 'onclick="cancelar()"');
      $form .= self::close();
      return $form;
   } // END-__toString
  
  /**
   * OdaForm->getFields('legend Fieldset');
   */
  public function getFields($legend_fieldset): string {
    return self::getHiddens() . self::createFieldset($this->_ffields[1], $legend_fieldset);
  } // END-getFields
 

   /**
    * Retorna un campos Input dependiendo del "tipo".
    * @example echo $myForm->addInput(2, 'number', 'cantidad', '1', 'w3-red');
    * @link    https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input 
    * week url time text tel submit search reset range radio password number month image hidden file email datetime-local date color checkbox button
    */
   public function addInput(int $columna=1, string|bool $tipo=null, string $field='', $attr='', $inline=false) {
      $attr       = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
      $fieldname  = $this->_fname.'.'.trim($field);
      $label      = $this->getLabel($field, $inline);
      $help       = $this->getHelp($field);
      $value      = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);
      $widget     = (is_null($tipo)) ? $this->getWidget($field) : $tipo;
      $campo_input = $this::input($widget, $fieldname, $attr, $value);
      $this->_ffields[$columna] .= ($tipo=='hidden') ? $campo_input : "<br><label> $label" .$campo_input .$help ."</label>";
   } // END-addInput

   /**
    * Retorna un campo FILE.
    * @link    https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file
    */
   public function addFile(int $columna=1, string $field='', $attr='', $inline=false) {
    $attr       = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
    $fieldname  = trim($field);
    $label      = $this->getLabel($field, $inline);
    $help       = $this->getHelp($field);
    $campo_file  = $this::file($fieldname, $attr);
    $this->_ffields[$columna] .= "<br><label> $label" .$campo_file .$help ."</label>";
   }
   /**
    * Retorna un campos Input dependiendo del "tipo".
    * @example echo $myForm->addInput(2, 'number', 'cantidad', '1', 'w3-red');
    * @link    https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input 
    */
    public function addInput2(int $columna=1, string|bool $tipo=null, string $field='', $attr='', $inline=true) {
      $attr       = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
      $fieldname  = $this->_fname.'.'.trim($field);
      $widget     = (is_null($tipo)) ? $this->getWidget($field) : $tipo;
      $label      = $this->getLabel($field, $inline);
      $help       = $this->getHelp($field);
      $value      = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);

      $campo_input = $this::input($widget, $fieldname, $attr, $value);
      $this->_ffields[(int)$columna] .= ($tipo=='hidden') ? $campo_input : "<label>$label" .$campo_input."</label>";
   } // END-addInput

   
   /**
    * Retorna un campos Texarea.
    * @example echo $myForm->addInput(2, 'number', 'cantidad', '1', 'w3-red');
    * @link    https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input 
    */
    public function addTextarea(int $columna=1, string $field='', $attr='', $inline=true) {
      $attr       = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
      $fieldname  = $this->_fname.'.'.trim($field);
      $label      = $this->getLabel($field, $inline);
      $help       = $this->getHelp($field);
      $value      = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);

      $campo_textarea = $this::textarea($fieldname, $attr, $value);
      $this->_ffields[$columna] .= "<br><label>$label" .$campo_textarea .$help ."</label>";
   } // END-addTextarea

   /**
    * Retorna un campo Select.
    * @example $myForm->addSelect(2, 'seccion_id', '1', 'w3-red');
    */
   public function addSelect(int $columna=1, string $field='', array $data=[], string $attr='') {
      $attr = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
      $fieldname  = trim($this->_fname.'.'.$field);
      $label       = $this->getLabel($field);
      $help        = $this->getHelp($field);
      $value = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field) ;

      $campo_select = $this::select($fieldname, $data, $attr, $value);
      $this->_ffields[(int)$columna] .= "<br><label> $label $campo_select $help </label>";
   } // END-addSelect

   
   
   /**
    * Retorna un campo CHECKBOX.
    * @example echo $myForm->addCheck(2, 'is_active', 'class="w3-red"');
    * @link    https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/checkbox
    */
    public function addCheck(int $columna=1, string $field='', string|array $attr=''){
      $fieldname  = trim($this->_fname.'.'.$field);
      $label = $this->getLabel($field);
      $help  = $this->getHelp($field);
      $value = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field);
      $value = ($value) ? 1 : 0 ;
      $is_checked = ($value) ? true : false ;

      $check = Form::check($fieldname, $value, $attr, $is_checked).'<br>'.$help;
      $this->_ffields[(int)$columna] .= "<br><label> $label $check </label><br>";
   }

   
   /**
    * Retorna un campos radio button.
    * @example echo $myForm->addInput(2, 'number', 'cantidad', '1', 'w3-red');
    * @link    https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input 
    */
   public function addRadio(int $columna=1, string $field='', string|array $attrs='', bool $checked=false){
      /*
      <fieldset>
         <legend>Select a maintenance drone:</legend>
         <div>
            <input type="radio" id="huey" name="drone" value="huey"
                  checked>
            <label for="huey">Huey</label>
         </div>
         <div>
            <input type="radio" id="louie" name="drone" value="louie">
            <label for="louie">Louie</label>
         </div>
      </fieldset>
       */
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
   }

   /**
    * Lo declara como formulario de edición.
    * @param int $max_cols: número de columnas del formulario.
    * @return void
    * @example echo $myForm->setColumnas(2);
    */
   public function setEdit() {
      $this->_isEdit = true;
   }

   /**
    * Establece el número de columnas que tendrá el formuario.
    * @example echo $myForm->setColumnas(2);
    */
   public function setColumnas(int $max_cols=1) {
      $this->_ffields  = array_fill(1, (int)$max_cols, ' ');
   }

   /**
    * Establece los atributos que tendrá el formuario.
    * @example echo $myForm->setColumnas(2);
    */
   public function setAtrib(string|array $attrs = '') {
      $this->_fattrs = self::getAttrs($attrs);
   }

   private function isRequired($field) {
      $attribs = $this->_modelo->getAttrib($field);
      return str_contains($attribs, 'required');
   }

   private function getDefault($field) {
      return (($this->_modelo->getDefault($field)) ? $this->_modelo->getDefault($field) : '') ;
   } // END-getDefault

   /**
    * 
    */
   private function getLabel($field, $inline=false) {
      $requerido = ($this->isRequired($field)) ? '<i class="fa-solid fa-bolt"></i> ' : '' ;
      $in_line = ($inline) ? '' : '<br>' ;
      return (($this->_modelo->getLabel($field)) ? '<b>'.$requerido.$this->_modelo->getLabel($field).$in_line.'</b>' : OdaUtils::nombrePersona($field)) ;
   } // END-getLabel


   private function getHelp($field) {
      return (($this->_modelo->getHelp($field)) ? '<i class="fa-solid fa-circle-info"></i> <small>'.$this->_modelo->getHelp($field).'</small>' : '') ;
   } // END-getHelp

   private function getPlaceholder($field) {
      return (($this->_modelo->getPlaceholder($field)) ? ' placeholder="'.$this->_modelo->getPlaceholder($field).'" ' : '') ;
   } // END-getPlaceholder

   private function getAttrib($field) {
      return (($this->_modelo->getAttrib($field)) ? ' '.$this->_modelo->getAttrib($field).' ' : '') ;
   } // END-getAttrib


   private function getWidget($field) {
    return (($this->_modelo->getWidget($field)) ? $this->_modelo->getWidget($field) : 'input') ;
  } // END-getWidget

   /**
    * Establece cuáles campos serán ocultos (type="hide") en el formulario.
    * @example        echo $myForm->setHiddens('id, created_by, updated_by, created_at, updated_at, is_active');
    */
    public function addHiddens($fields='id') {
      $this->_fhiddens = str_replace(' ', '', $fields);
   } // END-setHiddens

   /**
    * Retorna todos los campos tipo "hidden" que están en $_fhiddens.
    * @example echo OdaForm->getHiddens();
    */
   public function getHiddens() {
      $campos = explode(',',$this->_fhiddens);
      $result = '';
      foreach ($campos as $campo) {
        $value_input = ($this->_isEdit) ? $this->_modelo->$campo : $this->getDefault($campo) ;
        $result .= form::hidden($this->_fname.'.'.trim($campo), '', $value_input);
      }
      return $result;
   } // END-getHiddens
   

   /**
    * Crea un Input 'Search' para filtrar dentro de una tabla de datos
    * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/search
    * @example echo OdaForm::inputSerach();
    */
   public static function inputSearch(string $input_search_id='inputSearch', string $table_id='mytable', string $placeholder="Filtrar") {
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
   } // END-inputSerach


  /**
   * Crea un Input 'Range'
   * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/range
   * @example echo OdaForm::inputRango(id: 'ir1', caption: 'Rango de Valores', value: 5, min:0, max=10, step=1)
   */
  public static function inputRango(string $id_name, string $caption, int $value, int $min=0, int $max=100, int $step=1) {
    return ($min<=$value && $value<=$max) ?
          "<div>
              <input type=\"range\" id=\"range_$id_name\" name=\"$id_name\" min=\"$min\" max=\"$max\" value=\"$value\" step=\"$step\">
              <label for=\"$id_name\">$caption</label>
              <p>Value: <output id=\"out_range_$id_name\"></output></p>
           </div>"
           : "inputRange : valor fuera de rango" ;
  } // END-inputRango

  public static function inputRangoJs ($range_id) {
    return 
    "const value = document.querySelector(\"#out_range_$range_id\")
     const input = document.querySelector(\"#range_$range_id\")

     value.textContent = input.value

     input.addEventListener(\"input\", (event) => {
       value.textContent = event.target.value
     })";
  }
  

    /**
     * Crea un fieldset
     * @example echo OdaForm->->createFielset('Contenido', 'Columna 1', 'class="w3-half"');
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/fieldset
     * */
   private static function createFieldset($content, $legend = '', $attrs = '') {
      return "<fieldset $attrs> 
                  <legend> $legend </legend>
                  $content
              </fieldset>";
    }

    
    /**
     * Convierte los argumentos de un metodo de parametros por nombre a un string con los atributos
     * @return string
     */
   public static function getAttrs($params) {
      if (!is_array($params)) { return (string)$params; }
      $data = '';
      foreach ($params as $k => $v) {
          $data .= "$k=\"$v\" ";
      }
      return trim($data);
   }
  
   /**
    * Crea un tag HTML
    * */
   public static function createTag($tag, $content = null, $attrs = '') {
      if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
      if (is_null($content)) { return "<$tag $attrs/>"; }
      return "<$tag $attrs>$content</$tag>";
   }

   public function v(){
      $version = \DateTime::createFromFormat('Y.m.d', $this->version);
      return 'PHP Helper OdaForm -> Version '.$version->format('d M Y');
   }
} // END-Class