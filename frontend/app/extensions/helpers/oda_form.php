<?php
/**
 * Helper para Formularios Odair.
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source   frontend\app\extensions\helpers\oda_form.php
 */
class OdaForm extends Form {
   private $version = '2002.07.04';
   private $_style = ' class="w3-input w3-border" ';
   private $_modelo = '';
   private $_fname   = '';
   private $_faction = '';
   private $_fmethod = '';
   private $_fattrs = '';
   private $_fhiddens = '';
   private $_ffields = array(1=>' ');
   private $_isEdit = false;
   
   const METHOD = [
      'POST' => 'post',
      'GET'  => "get",
   ];

   /**
    * @param string        $modelo: modelo de datos que usará.
    * @param string        $action: accion del formulario.
    * @param int           $max_cols: número de columnas del formulario.
    * @param string        $method: método HTTP que usará el formulario.
    * @param string/array  $attr: atributos html.
    * @return void
    * @example echo $myForm = new OdaForm('Grado', 'admin/grados/create', 2);
    * @source  frontend\app\extensions\helpers\oda_form.php
    */
   public function __construct(object $modelo, string $action, string $method = self::METHOD['POST']) {
      $this->_modelo   = $modelo;
      $this->_fname    = strtolower(OdaUtils::pluralize($modelo::class));
      $this->_faction  = $action;
      $this->_fmethod  = $method;
   } // END-__construct

   public function __toString(): string {
      $cols_max = array_key_last($this->_ffields);
      $form  = '';
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

      $form .= self::open($this->_faction, $this->_fmethod, $this->_fattrs);
      $form .= self::getHiddens();
      $form .= self::createTag('div', $data_sets, 'class="w3-row"');
      $form .= '<br>' .$this->submit('Guardar');
      $form .= self::close();
      return $form;
   } // END-__toString
   
   
   /**
    * Retorna un campos Input dependiendo del "tipo".
    * @param integer           $columna:  Columna en la que se muestrará el elemento.
    * @param string            $tipo:     Tipo de input (text, number, etc).
    * @param string            $field:    Nombre del campo en la tabla.
    * @param string|Integer    $value:    Valor por defecto.
    * @param string/array      $attr:     atributos html.
    * @return string
    * @example echo $myForm->addInput(2, 'number', 'cantidad', '1', 'w3-red');
    * @link    https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input 
    */
   public function addInput(int $columna=1, string $tipo, string $field, $attr='', $inline=false) {
      $attr        = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
      $fieldname   = $this->_fname.'.'.trim($field);
      $label       = $this->getLabel($field, $inline);
      $help        = $this->getHelp($field);
      $value_input = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field) ;

      $campo_input = $this::input($tipo, $fieldname, $attr, $value_input);
      $this->_ffields[(int)$columna] .= ($tipo=='hidden') ? $campo_input : "<br><label> $label" .$campo_input .$help ."</label><br>";
   } // END-addInput

   
   /**
    * Retorna un campo Select.
    * @param integer           $columna:  Columna en que se muestra.
    * @param string            $field:    Nombre del campo en la tabla.
    * @param string|Integer    $value:    Valor por defecto.
    * @param string/array      $attr:     atributos html.
    * @return string
    * @example $myForm->addSelect(2, 'seccion_id', '1', 'w3-red');
    */
    public function addSelect(int $columna, string $field, array $data, string $attr='') {
      $attr = $this->_style . (($attr) ? $attr : $this->getAttrib($field)) .$this->getPlaceholder($field) ;
      $fieldname  = trim($this->_fname.'.'.$field);
      $label       = $this->getLabel($field);
      $help        = $this->getHelp($field);
      $value = ($this->_isEdit) ? $this->_modelo->$field : $this->getDefault($field) ;

      $campo_select = $this::select($fieldname, $data, $attr, $value);
      $this->_ffields[(int)$columna] .= "<br><label> $label" .$campo_select .$help ."</label><br>";
   } // END-addInput

   
   /**
    * Establece el número de columnas que tendrá el formuario.
    * @param int $max_cols: número de columnas del formulario.
    * @return void
    * @example echo $myForm->setColumnas(2);
    */
    public function setEdit() {
      $this->_isEdit = true;
   }

   /**
    * Establece el número de columnas que tendrá el formuario.
    * @param int $max_cols: número de columnas del formulario.
    * @return void
    * @example echo $myForm->setColumnas(2);
    */
   public function setColumnas(int $max_cols=1) {
      $this->_ffields  = array_fill(1, (int)$max_cols, ' ');
   }

   /**
    * Establece los atributos que tendrá el formuario.
    * @param string|array $attrs: atributos.
    * @return void
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

   private function getLabel($field, $inline=false) {
      $requerido = ($this->isRequired($field)) ? '** ' : '' ;
      $in_line = ($inline) ? '<br>' : '' ;
      return (($this->_modelo->getLabel($field)) ? '<b>'.$requerido.$this->_modelo->getLabel($field).$in_line.'</b>' : '') ;
   } // END-getLabel

   private function getHelp($field) {
      return (($this->_modelo->getHelp($field)) ? _Icons::solid('circle-info').' <small>'.$this->_modelo->getHelp($field).'</small>' : '') ;
   } // END-getHelp

   private function getPlaceholder($field) {
      $requerido = ($this->isRequired($field)) ? 'obligatorio ' : '' ;
      return (($this->_modelo->getPlaceholder($field)) ? ' placeholder="'.$requerido.': '.$this->_modelo->getPlaceholder($field).'" ' : '') ;
   } // END-getPlaceholder

   private function getAttrib($field) {
      return (($this->_modelo->getAttrib($field)) ? ' '.$this->_modelo->getAttrib($field).' ' : '') ;
   } // END-getAttrib


   /**
    * Establece cuáles campos serán ocultos (type="hide") en el formulario.
    * @param  string  $fields  Lista de campos (separados por coma).
    * @return string
    * @example        echo $myForm->setHiddens('id, created_by, updated_by, created_at, updated_at, is_active');
    */
    public function addHiddens($fields='id') {
      $this->_fhiddens = str_replace(' ', '', $fields);
   } // END-setHiddens

   /**
    * Retorna todos los campos tipo "hidden" que están en $_fhiddens.
    * @return string
    * @example echo _Form->getHiddens();
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
    * @return string
    * @link https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/search
    * @example echo _Form::inputSerach();
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
    */
    public static function inputRango($id,$caption,$value,$min=1,$max=10,$step=1) {
       return 
       "<div>
          <input type=\"range\" id=\"$id\" name=\"$id\" 
            min=\"$min\" max=\"$max\" value=\"$value\" step=\"$step\">
          <label for=\"$id\">$caption</label>
        </div>";
    } // END-inputRango


    /**
     * Crea un fieldset
     *
     * @return string
     * @example echo _Form->->createFielset('Contenido', 'Columna 1', 'class="w3-half"');
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
     *
     * @param string|array $params argumentos a convertir
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
    *
    * @param string $tag nombre de tag
    * @param string|null $content contenido interno
    * @param string|array $attrs atributos para el tag
    * @return string
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