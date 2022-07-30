<?php
/**
 * OdaTable: Helper para Formularios Odair.
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source   frontend\app\extensions\helpers\oda_table.php
 */
class OdaTable {
   private $_thead  = '';
   private $_tbody  = '';
   private $_tbody_cont = 0;
   private $_tfoot  = '';
   private $_tcaption = '';
   private $_tcaption_attrs = 'class="w3-left-align w3-bottombar w3-border-blue"';
   
   public function __construct(
      private string|array $_attrs='id="myTable" class="w3-table w3-responsive w3-bordered"',
      private string $_theme = 'dark'
   ) {
   }
   
   public function __toString() {
      return  "<h5>Total Registros: $this->_tbody_cont</h5>"
             ."<table $this->_attrs>
                  $this->_tcaption
                  $this->_thead
                  <tbody id=\"searchBody\">
                     $this->_tbody
                  </tbody>
                  $this->_tfoot
               </table>";
   }
   
   /**
    * Formatea el encabezado de la Tabla.
    *
    * @param string $arr_head: encabezados de cada columna (separados por coma).
    * @param string $attrs: 
    * @param string $attrs2:
    * @return string
    * @example echo $myForm = new OdaForm('Grado', 'admin/grados/create', 2);
    * @source  frontend\app\extensions\helpers\oda_form.php
    */
   public function setHead(
      string|array $arr_head='', 
      string|array $attrs='', 
      array $attrs2=array()
   ):void 
   {
      $arr_head = self::strToArray($arr_head);
      $attrs = self::getAttrs($attrs);
      $head = '';
      foreach ($arr_head as $key => $th) {
         $atr2 = (array_key_exists($key, $attrs2)) ? $attrs2[$key] : '' ;
         $head .= "<th $atr2>$th</th>";
      }
      $this->_thead = "<thead $attrs><tr>".$head.'</tr></thead>';
   }
   
   public function setBody(
      string|array $data, 
      string|array $attrs='', 
      string|array $attrs2=array()
   ):void 
   {
      $data  = self::strToArray($data);
      $attrs = self::getAttrs($attrs);
      $this->_tbody_cont +=1;
      $t = substr($this->_theme, 0, 1);
      if (!$attrs) {
         $attrs = ($this->_tbody_cont%2==0) ?  "class=\"item w3-theme-{$t}1\"" :  "class=\"item w3-theme-{$t}4\"" ;
      }
      $this->_tbody.= "<tr $attrs>";
      foreach ($data as $key => $td) {
         $atr2 = (array_key_exists($key, $attrs2)) ? $attrs2[$key] : '' ;
         $this->_tbody.= "<td $atr2>".$td.'</td>';
      }
      $this->_tbody.= '</tr>';
   }

   public function setFoot(string|array $arr_foot, string|array $attrs=''):void {
      $arr_foot = self::strToArray($arr_foot);
      $attrs = self::getAttrs($attrs);
      $foot = '';
      foreach ($arr_foot as $td) {
         $foot .= "<td>$td</td>";
      }
      $this->_tfoot = '<tfoot><tr>'.$foot.'</tr></tfoot>';
   }

   public function setCaption(string $caption, string|array $attrs=''):void {
      $attrs = self::getAttrs($attrs);
      $attrs = ($attrs) ? $attrs : $this->_tcaption_attrs ;
      $this->_tcaption = "<caption $attrs><h2>" .strtoupper($caption) .'</h2></caption>';
   }

   
   public static function multiTags(string|array $data, string $tag='span', string|array $attrs=''): string {
      if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
      $tags='';
      foreach ($data as $value) { $tags .="<$tag $attrs>".$value."</$tag>"; }
      return $tags;
   } // END-multiTags

   public static function strToArray(string|array $params):array {
      if (!is_string($params)) { return (array) $params; }
      return explode(',', $params);
   } // END-strToArray

   public static function getAttrs(string|array $params): string {
       if (!is_array($params)) { return (string)$params; }
       $data = '';
       foreach ($params as $k => $v) { $data .= "$k=\"$v\" "; }
       return trim($data);
   } // END-getAttrs
   
} // END-OdaTable