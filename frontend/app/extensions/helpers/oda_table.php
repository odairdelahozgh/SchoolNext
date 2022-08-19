<?php
/**
 * OdaTable: Helper para TABLAS Odair.
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source   frontend\app\extensions\helpers\oda_table.php
 */
class OdaTable {
   private string $_thead  = '';
   private string $_tbody  = '';
   private int $_tbody_cont = 0;
   private string $_tfoot  = '';
   private string $_tcaption = '';
   private string $_tcaption_attrs = 'class="w3-left-align w3-bottombar w3-border-blue"';
   
   public function __construct(
      private string|array $_attrs='id="myTable" class="w3-table w3-responsive w3-bordered"',
      private string $_theme = 'dark'
   ) {
   }

   /**
    * Muestra la tabla
    */
   public function __toString() {
      return "<div class=\"w3-container\">"
               ."<table $this->_attrs>
                     $this->_tcaption
                     $this->_thead
                     <tbody id=\"searchBody\">
                        $this->_tbody
                     </tbody>
                     $this->_tfoot
                  </table>
                  <h5>Total Registros: $this->_tbody_cont</h5>
             </div>";
   }
   
   /**
    * Formatea el encabezado de la Tabla.
    *
    * @example echo $tabla->setHead(
         arr_head: ['Actions', 'Estudiante', 'Cambiar Salon'], 
         attrs:    'class="w3-theme"', 
         attrs2:   ['style="width:10%;"','style="width:60%;"','style="width:30%;"']
      );
    */
   public function setHead(
      string|array $arr_head = '', 
      string|array $attrs    = 'class="w3-theme"', 
      array $attrs2          = array()
   )
   {
      $arr_head = self::strToArray($arr_head);
      $attrs = self::getAttrs($attrs);
      $head = '';
      foreach ($arr_head as $key => $th) {
         $atr2 = (array_key_exists($key, $attrs2)) ? $attrs2[$key] : '' ;
         $head .= "<th $atr2>".strtoupper(trim($th))."</th>";
      }
      $this->_thead = "<thead $attrs><tr>".$head.'</tr></thead>';
      return $this;
   }
   
   /**
    * Añade una fila al Body de la Tabla.
    *
    * @example echo $tabla->setBody(
            data: $data, 
            attrs2: ['class="searchTdata w3-center"', 'class="searchTdata"']
         );
    */
   public function setBody(
      string|array $data, 
      string|array $attrs  = '', 
      string|array $attrs2 = array()
   )
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
         $this->_tbody.= "<td $atr2>".trim($td).'</td>';
      }
      $this->_tbody.= '</tr>';
      return $this;
   }

   /**
    * Formatea el pie de la Tabla.
    *
    * @example echo $tabla->setFoot(
         arr_foot: ['', 'Total: ', 100000], 
         attrs:    'class="w3-theme"'
      );
    */
   public function setFoot(string|array $arr_foot, string|array $attrs = '')
   {
      $arr_foot = self::strToArray($arr_foot);
      $attrs = self::getAttrs($attrs);
      $foot = '';
      foreach ($arr_foot as $td) {
         $foot .= "<td>".trim($td)."</td>";
      }
      $this->_tfoot = '<tfoot><tr>'.$foot.'</tr></tfoot>';
      return $this;
   }

   /**
    * Establece la etiqueta CAPTION de la Tabla.
    * @example echo $tabla->setCaption(arr_foot: "Titulo de la tabla");
    */
   public function setCaption(
      string $caption, 
      string|array $attrs=''
   )
   {
      $attrs = self::getAttrs($attrs);
      $attrs = ($attrs) ? $attrs : $this->_tcaption_attrs ;
      $this->_tcaption = "<caption $attrs><h2>".strtoupper($caption).'</h2></caption>';
      return $this;
   } // END-setCaption

   /**
    * crea múltiples tags html 
    */
   public static function multiTags(string|array $data, string $tag='span', string|array $attrs=''): string {
      if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
      $tags='';
      foreach ($data as $value) { $tags .="<$tag $attrs>".$value."</$tag>"; }
      return $tags;
   } // END-multiTags
   
   /**
    * Convierte un string separado por comas en un array.
    */
   public static function strToArray(string|array $params):array {
      if (!is_string($params)) { return (array) $params; }
      return explode(',', $params);
   } // END-strToArray

   /**
    * 
    */
   public static function getAttrs(string|array $params): string {
       if (!is_array($params)) { return (string)$params; }
       $data = '';
       foreach ($params as $k => $v) { $data .= "$k=\"$v\" "; }
       return trim($data);
   } // END-getAttrs
   
} // END-OdaTable