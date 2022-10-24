<?php
/**
 * OdaTable: Helper para TABLAS Odair.
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source   frontend\app\extensions\helpers\oda_table.php
 */
class OdaTable {
   private string $tHead    = '';
   private string $tBody    = '';
   private string $tFooter  = '';
   private string $tCaption = '';
   private int    $body_counter = 0;
   
   public function __construct(
      private string|array $_attrs='id="myTable" class="w3-table w3-responsive w3-striped w3-bordered"',
      private string $theme = '',
      private array $searchCol = [1],
      private bool $showTotalRegs = false,
   ) {
      $this->theme = Session::get('theme') ?? 'dark';
   }

   /**
    * Muestra la tabla
    */
   public function __toString() { 
      $total_regs = ($this->showTotalRegs) ? "<h5>Total Registros: $this->body_counter</h5>" : '' ;
      return "<div class=\"w3-container\">"
               ."<table $this->_attrs>
                     $this->tCaption
                     $this->tHead
                     <tbody id=\"searchBody\">
                        $this->tBody
                     </tbody>
                     $this->tFooter
                  </table>
                  $total_regs
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
      $attrs = self::getAttrs($attrs);
      $head = '';
      foreach (self::strToArray($arr_head) as $key => $th) {
         $atr2 = (array_key_exists($key, $attrs2)) ? $attrs2[$key] : '' ;
         $head .= "<th $atr2>".trim($th)."</th>";
      }
      $this->tHead = "<tHead $attrs><tr>".$head.'</tr></tHead>';
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
      string|array $attrs2 = [],
   )
   {
      $data  = self::strToArray($data);
      $attrs = self::getAttrs($attrs);
      $this->body_counter +=1;
      $t = substr($this->theme, 0, 1);
      if (!$attrs) {
         $par   = ($t=='d')?'d1':'l4';
         $impar = ($t=='d')?'d4':'l1';
         $attrs = ($this->body_counter%2==0) ?  "class=\"item w3-theme-$par\"" :  "class=\"item w3-theme-$impar\"" ;
      }
      $this->tBody.= "<tr $attrs>";
      foreach ($data as $key => $td) {
         $atr2 = '';
         if ($attrs2) {
            $atr2 = (array_key_exists($key, $attrs2)) ? $attrs2[$key] : '' ;
         }

         if (array_search($key, $this->searchCol)) {
            if (str_contains($atr2, 'class')) {
               $atr2 = str_replace('class="', 'class="searchTdata ', $atr2);
            } else {
               $atr2 .= ' class="searchTdata" ';
            }
         }
         
         $this->tBody.= "<td $atr2>".trim($td).'</td>';
         //$this->tBody.= $this->setColumnData($td);
      }
      $this->tBody.= '</tr>';
      return $this;
   }

   private function setColumnData(string $tdata, string $attr='') {
      //$this->searchCol
      return "<td $attr>".trim($tdata).'</td>';
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
      $foot = '';
      foreach (self::strToArray($arr_foot) as $td) {
         $foot .= "<td>".trim($td)."</td>";
      }
      $this->tFooter = '<tfoot '.self::getAttrs($attrs).'><tr>'.$foot.'</tr></tfoot>';
      return $this;
   }

   /**
    * Establece la etiqueta CAPTION de la Tabla.
    * @example echo $tabla->setCaption(arr_foot: "Titulo de la tabla");
    */
   public function setCaption(
      string $caption, 
      string|array $attrs='class="w3-left-align w3-bottombar w3-border-blue"'
   )
   {
      $this->tCaption = '<caption '.self::getAttrs($attrs).'><h3>'.$caption.'</h3></caption>';
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