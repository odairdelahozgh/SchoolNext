<?php

class OdaTags {

   // HELPERS PARA TABLAS
   public static function multiTags( $tag='span', $data=array(), $attrs='' ) {
      if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
      $tags='';
      foreach ($data as $value) { $tags .="<$tag $attrs>".$value."</$tag>"; }
      return $tags;
   } // END-multiTags

   // HELPERS PARA LINKS    
   public static function getAttrs($params) {
       if (!is_array($params)) {
           return (string)$params;
       }
       $data = '';
       foreach ($params as $k => $v) {
           $data .= "$k=\"$v\" ";
       }
       return trim($data);
   } // END-getAttrs

   public static function link($action='', $text='Inicio', $attrs = '') {
      if (is_array($attrs)) {
         $attrs = self::getAttrs($attrs);
      }
      return '<a href="'.PUBLIC_PATH."$action\" $attrs>$text</a>";
   } // END-link
   
   public static function linkBarItem($action, $text, $icon='home') { 
      return '<span class="w3-bar-item w3-hover-blue">'
                ._Icons::solid($icon, "w3-large").'&nbsp;'
                .self::link($action, $text)
            .'</span>';
    } // END-linkBarItem

    public static function linkExterno($url, $text, $attrs = '') {
      if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
      return "<a href=\"$url\" $attrs  target=\"_blank\">$text</a>";
    } // END-linkExterno

    //====================
    public static function linkButton($action, $text, $icon='', $attrs = 'class="w3-button w3-green"') { 
      if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
      return self::link($action, _Icons::solid($icon).'&nbsp;'.$text, $attrs);
    } // END-linkButton

    // ===================
    public static function linkIcon($action='', $icon='', $attr='') {
      return self::link($action, _Icons::solid($icon), $attr).'&nbsp;';
    } // END-linkIcon

    public static function linkBC($action, $text) { 
      return '&nbsp;'._Icons::solid('angles-right', "w3-small").'&nbsp;'
            .self::link($action, $text, "title=\"Volver a $text\"");
    } // END-linkBC
    
    //====================
    public static function img($src, $alt = '', $attrs = '', $err_message='no image') {
      if (!file_exists(ABS_PUBLIC_PATH."/img/$src")) {
         return $err_message;
      }
        return '<img src="'.PUBLIC_PATH."img/$src\" alt=\"$alt\" ".Tag::getAttrs($attrs).'/>';
    } // END-img
    
    //====================
    public static function fileimg($src, $alt = '', $attrs = '', $err_message='no image') {
      if (!file_exists(ABS_PUBLIC_PATH."/files/upload/$src")) {
         return $err_message;
      }
        return '<img src="'.PUBLIC_PATH."files/upload/$src\" alt=\"$alt\" ".Tag::getAttrs($attrs).'/>';
    } // END-fileimg


   // HELPERS PARA LISTS
   public static function list($array, $type = 'ul', $attrs = 'class="w3-ul w3-card-4 w3-hoverable"') {
      if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
      $list = "<$type $attrs>".PHP_EOL;
      foreach ($array as $item) { $list .= "<li>$item</li>".PHP_EOL; }
      return "$list</$type>".PHP_EOL;
   }
 
  /**
   * dlist: DEscription Lists
   * @source https://developer.mozilla.org/en-US/docs/Learn/HTML/Introduction_to_HTML/Advanced_text_formatting
   */
  public static function dlist(array $arr_description, array|string $attrs = 'class="w3-ul w3-card-4 w3-hoverable"') {
    if (is_array($attrs)) { $attrs = self::getAttrs($attrs); }
    $type = 'dl';

    $list = "<$type $attrs>".PHP_EOL;
    foreach ($arr_description as $term => $definition) { 
      $list .= "<dt>$term</dt><dd>$definition</dd>".PHP_EOL; 
    }
    return "$list</>".PHP_EOL;
  }

   public static function meter($nivel, $titulo='', $rango=array(33,66,80)){
      return "<label>$titulo:
         <meter
               min=\"0\" max=\"100\"
               low=\"$rango[0]\" high=\"$rango[1]\" optimum=\"$rango[2]\"
               value=\"$nivel\">
            $nivel/100
         </meter>
      </label>".PHP_EOL;
   }

   public static function tooltip(string $text, string $tip){
      return '<span class="w3-tooltip">'.$text.'<span style="position:absolute;left:0;bottom:18px" class="w3-text w3-tag">'.$tip.'</span></span>';
   }

   public static function quarter($titulo, $valor, $link=null, $icon=null) {
    return "<div class=\"w3-quarter w3-padding w3-center\">
                <div class=\"w3-card w3-container w3-round-large w3-theme-l3 w3-hover-theme\">
                  <header class=\"w3-container\">
                    <h4 class=\"w3-left\">$titulo</h>
                  </header>
                    <p class=\"w3-left\">$icon</p>
                    <h3 class=\"w3-right w3-xxxlarge\">$valor</h3>
                  <footer class=\"w3-container\">
                    <h5 class=\"w3-\">$link</h5>
                  </footer>
                </div>
            </div>";
   }

   public static function buttonBars(array $arrButtons=[]) {
    $btns = '';
    foreach ($arrButtons as $key => $button) {
      $btns .= "<button id=\"btn1\" class=\"w3-button w3-theme\" onclick=\"".$button['action']."\">".$button['caption']."</button>";
    }
    return "<div class=\"w3-bar\">$btns</div>";
   }

} // END-_Tag