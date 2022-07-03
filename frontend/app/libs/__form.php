<?php
/**
 * Helper para Formularios con W3-CSS.
 * 
 * @category  Helper.
 * @package   KumbiaPHP.
 * @author    ConstruxZion Soft (odairdelahoz@gmail.com).
 * @todo      Reemplazar todos los tipos de campos de la clase Form que viene en el Core.
 */
   
/**
 * Helper para construir formularios.
 */
class _Form extends Form {
   private $_style = ' class="w3-input w3-border" ';
   private $_modelo = '';
   private $_fname   = '';
   private $_faction = '';
   private $_fmethod = '';
   private $_fattrs = '';
   private $_fhiddens = '';
   private $_ffields = array();
   public $_isNew = false;
   
   public function __construct($modelo, $action, $cols=1, $method='post', $attrs = '') {
      $this->_modelo   = new $modelo;
      $this->_fname    = $this->_modelo->getFormName($modelo);
      $this->_faction  = $action;
      $this->_fmethod  = $method;
      $this->_fattrs   = $attrs;
      $this->_ffields  = array_fill(1, (int)$cols, ' ');
   } // END-__construct


  public function __toString() {

      $salida = self::open($this->_faction, $this->_fmethod, $this->_fattrs)
               .self::getHiddens();
      $cols_max = array_key_last($this->_ffields);

      if ($cols_max==2) {
         $fielset1 = self::createFieldset($this->_ffields[1], 'Columna 1', 'style="width:90%"');
         $columna1 = Tag::create('div', $fielset1, 'class="w3-half"');         
         
         $fielset2 = self::createFieldset($this->_ffields[2], 'Columna 2', 'style="width:90%"');
         $columna2 = Tag::create('div', $fielset2, 'class="w3-rest"');
         
         $salida .= Tag::create('div', $columna1.$columna2, 'class="w3-row"');

      } else {
         $fieldset = self::createFieldset($this->_ffields[1], 'Registro', 'style="width:50%"');
         $salida .= Tag::create('div', $fieldset, 'class="w3-row"');
      }
      $salida .= '<br>'.$this->submit('Guardar').'<br>';
      $salida .= $this->close().'<br>';
      return $salida;
   } // END-__toString
   
   

   private function isRequired($field) {
      $attribs = (new $this->_modelo)->getAttrib($field);
      return str_contains($attribs, 'required');
   }

   private function getDefault($field) {
      return (((new $this->_modelo)->getDefault($field)) ? (new $this->_modelo)->getDefault($field) : '') ;
   } // END-getDefault

   private function getLabel($field, $inline=false) {
      $info_reg = ($this->isRequired($field)) ? '** ' : '' ;
      $in_line = ($inline) ? '<br>' : '' ;
      return (((new $this->_modelo)->getLabel($field)) ? '<b>'.$info_reg.(new $this->_modelo)->getLabel($field).'</b><br>' : '') ;
   } // END-getLabel

   private function getHelp($field) {
      $info_reg = ($this->isRequired($field)) ? 'requerido: ' : '' ;
      return (((new $this->_modelo)->getHelp($field)) ? _Icons::solid('circle-info').' <small>'.$info_reg.(new $this->_modelo)->getHelp($field).'</small><br>' : '') ;
   } // END-getHelp

   private function getPlaceholder($field) {
      return (((new $this->_modelo)->getPlaceholder($field)) ? ' placeholder="'.(new $this->_modelo)->getPlaceholder($field).'" ' : '') ;
   } // END-getPlaceholder

   private function getAttrib($field) {
      return (((new $this->_modelo)->getAttrib($field)) ? ' '.(new $this->_modelo)->getAttrib($field).' ' : '') ;
   } // END-getAttrib

   /**
    * Retorna un campos Input dependiendo del "tipo".
    * @param integer           $columna:  Columna en que se muestra.
    * @param string            $tipo:     Tipo de input (text, number, etc).
    * @param string            $field:    Nombre del campo en la tabla.
    * @param string|Integer    $value:    Valor por defecto.
    * @param string/array      $attr:     atributos html.
    * @return string
    * @example echo $Modelo = new Grado();
    * @example echo $myForm = new _Form($Modelo, 'admin/grados/create', 2);
    * @example echo $myForm->addInput(2, 'number', 'cantidad', '1', 'w3-red');
    * @link    https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input  
    * @source  frontend\app\libs\ _form.php
    */
   public function addInput($columna, $tipo, $field, $attr='', $inline=false) {
      $form_field = trim($this->_fname.'.'.$field);
      $label = $this->getLabel($field, $inline);
      $help  = $this->getHelp($field);

      $modelo = $this->_modelo;

      $value = ($this->_isNew) ? $this->getDefault($field) : $modelo->$field;
      $attr  = ($attr) ? $attr : $this->getAttrib($field);
      $attrs = $this->_style.$this->getPlaceholder($field).$attr ;

      $campo_input = $this::input($tipo, $form_field, $attrs, $value);

      $this->_ffields[(int)$columna] .=
         "<label> $label" 
            .$campo_input .$help
        ."</label><br>";
   } // END-addInput

   
   /**
    * Retorna un campo Select.
    * @param integer           $columna:  Columna en que se muestra.
    * @param string            $field:    Nombre del campo en la tabla.
    * @param string|Integer    $value:    Valor por defecto.
    * @param string/array      $attr:     atributos html.
    * @return string
    * @example $Modelo = new Grado();
    * @example $myForm = new _Form($Modelo, 'grados/create', 2);
    * @example $myForm->addSelect(2, 'seccion_id', '1', 'w3-red');
    * @source frontend\app\libs\ _form.php
    */
    public function addSelect($columna, $field, $value=null, $attr='') {
      $name_field  = trim($this->_fname.'.'.$field);
      $label       = $this->getLabel($field);
      $help        = $this->getHelp($field);
      $default     = ($value) ? $value : $this->getDefault($field);
      $attr        = ($attr) ? $attr : $this->getAttrib($field);
      $attrs       = $this->_style.$this->getPlaceholder($field).$attr ;

      $campo_select = $this::select($name_field, $value, $attr).'<br>';

      $this->_ffields[(int)$columna] .=
         "<label> $label" 
            .$campo_select .$help
        ."</label><br>";
   } // END-addInput

   /**
    * Retorna todos los campos tipo "hidden" que están en $_fhiddens.
    * @return string
    * @example echo _Form->getHiddens();
    * @source frontend\app\libs\ _form.php
    */
   public function getHiddens() {
      $campos = explode(',',$this->_fhiddens);
      $result = '';
      foreach ($campos as $campo) {
        $default_value = (new $this->_modelo)->getDefault($campo);
        $result .= form::hidden(trim($this->_fname).'.'.trim($campo), '', $default_value);
      }
      return $result;
   } // END-getHiddens
   
   /**
    * Crea un Input 'Search' para filtrar dentro de una tabla de datos
    * @return string
    * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/search
    * @example echo _Form::inputSerach();
    * @source frontend\app\libs\ _form.php
    */
   public static function inputSerach($id='inputSerach') {
     $input = self::input('search', $id, "oninput=\"myFunctionFilter()\" class=\"w3-input w3-border\"  placeholder=\"Filtro..\"");
     $ico = _Icons::solid('search', 'w3-xxlarge');
     return  
       "<div class=\"w3-bar\">
          <div class=\"w3-bar-item\">$ico</div>
          <div class=\"w3-bar-item\">$input</div>
        </div>";
   } // END-inputSerach

   /**
    * Crea un Input 'Range'
    * @return string
    * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/range
    * @example echo _Form::range('r1','rango',5)
    * @source frontend\app\libs\ _form.php
    */
    public static function inputRango($id,$caption,$value,$min=1,$max=10,$step=1) {
       return 
       "<div>
          <input type=\"range\" id=\"$id\" name=\"$id\" 
            min=\"$min\" max=\"$max\" value=\"$value\" step=\"$step\">
          <label for=\"$id\">$caption</label>
        </div>";
    } // END-inputRango



   // /**
   //  * Establece cuáles campos serán ocultos (type="hide") en el formulario.
   //  * @param  string  $fields  Lista de campos (separados por coma).
   //  * @return string
   //  * @example        echo $myForm->setHiddens('id, created_by, updated_by, created_at, updated_at, is_active');
   //  * @source         frontend\app\libs\ _form.php
   //  */
   // public function setHiddens($fields='id') {
   //    $this->_fhiddens = $fields;
   // } // END-setHiddens
   
    
    /**
     * Crea un fieldset
     *
     * @return string
     * @example echo _Form->->createFielset('Contenido', 'Columna 1', 'class="w3-half"');
     * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/fieldset
     * @source frontend\app\libs\ _form.php
     * */
   private static function createFieldset($content, $legend = '', $attrs = '') {
      $legend = Tag::create('legend', $legend);
      return Tag::create('fieldset', $legend.$content, $attrs);
   }

   //  /**
   //   * Convierte los argumentos de un metodo de parametros por nombre a un string con los atributos
   //   *
   //   * @param string|array $params argumentos a convertir
   //   * @return string
   //   */
   // public static function getAttrs($params) {
   //    if (!is_array($params)) { return (string)$params; }
   //    $data = '';
   //    foreach ($params as $k => $v) {
   //        $data .= "$k=\"$v\" ";
   //    }
   //    return trim($data);
   // }
  
   // /**
   //  * Crea un tag HTML
   //  *
   //  * @param string $tag nombre de tag
   //  * @param string|null $content contenido interno
   //  * @param string|array $attrs atributos para el tag
   //  * @return string
   //  * */
   // public static function createTag($tag, $content = null, $attrs = '') {
   //    if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
   //    if (is_null($content)) { return "<$tag $attrs/>"; }
   //    return "<$tag $attrs>$content</$tag>";
   // }


} // END-Class