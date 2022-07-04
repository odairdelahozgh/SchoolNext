<?php

class OdaTable {
   private $_attrs = '';
   private $_thead  = '';
   private $_tbody  = '';
   private $_tfoot  = '';
   private $_tcaption = '';
   
   public function __construct($attrs='class="w3-table w3-border w3-bordered"') {
      $this->_attrs=$attrs;
   }
   
   public function __toString() {
      return  "<table $this->_attrs>
                  $this->_tcaption
                  $this->_thead
                  <tbody>
                     $this->_tbody
                  </tbody>
                  $this->_tfoot
               </table>";
   }
   
   public function head($arr_head, $attrs='', $attrs2=array()) {
      $arr_head = self::strToArray($arr_head);
      $attrs = self::getAttrs($attrs);
      $head = '';
      foreach ($arr_head as $key => $th) {
         $atr2 = (array_key_exists($key, $attrs2)) ? $attrs2[$key] : '' ;
         $head .= "<th $atr2>$th</th>";
      }
      $this->_thead = "<thead $attrs><tr>".$head.'</tr></thead>';
   }
   
   public function body($data, $attrs='', $attrs2=array()) {
      $data  = self::strToArray($data);
      $attrs = self::getAttrs($attrs);
      $this->_tbody.= "<tr $attrs>";
      foreach ($data as $key => $td) {
         $atr2 = (array_key_exists($key, $attrs2)) ? $attrs2[$key] : '' ;
         $this->_tbody.= "<td $atr2>".$td.'</td>';
      }
      $this->_tbody.= '</tr>';
   }

   public function foot($arr_foot, $attrs='') {
      $arr_foot = self::strToArray($arr_foot);
      $attrs = self::getAttrs($attrs);
      $foot = '';
      foreach ($arr_foot as $td) {
         $foot .= "<td>$td</td>";
      }
      $this->_tfoot = '<tfoot><tr>'.$foot.'</tr></tfoot>';
   }

   public function caption($caption, $attrs='class="w3-left-align"') {
      $attrs = self::getAttrs($attrs);
      $this->_tcaption = "<caption $attrs>" .strtoupper($caption) .'</caption>';
   }

   
   public static function multiTags($data, $tag='span', $attrs='') {
      if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
      $tags='';
      foreach ($data as $value) { $tags .="<$tag $attrs>".$value."</$tag>"; }
      return $tags;
   } // END-multiTags

   public static function strToArray($params) {
      if (!is_string($params)) { return (array) $params; 
      }
      return explode(',', $params);
   } // END-strToArray

   public static function getAttrs($params) {
       if (!is_array($params)) { return (string)$params; }
       $data = '';
       foreach ($params as $k => $v) { $data .= "$k=\"$v\" "; }
       return trim($data);
   } // END-getAttrs
   
} // END-_table