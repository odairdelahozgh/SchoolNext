<?php
/**
 * Theme: Helper para crear TABS Odair.
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source   frontend\app\extensions\helpers\oda_tabs.php
 */

enum ThemeColor {
  case primary;
  case secondary;
  case success;
  case danger;
  case warning;
  case info;
  case light;
  case dark;

} // END-ENUM


class Theme {
  
  public function __construct() {
  }

  public static function alert(string $message, ThemeColor $tcolor=ThemeColor::primary, $has_icon=true): string {
    $has_icon = ($has_icon)?'has-icon':'';
    $btn_close = '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>';
    return "<div class=\"alert alert-".$tcolor->name." $has_icon\" role=\"alert\">$message $btn_close</div>";
  } // END-link
  
  public static function badge(string $message, ThemeColor $tcolor=ThemeColor::primary, $pill =false, $bg_light=false): string {
    $class_pill = ($pill)?'badge-pill':'';
    $class_bg_light = ($bg_light)?'badge-subtle':'';
    return "<span class=\"badge $class_bg_light $class_pill badge-".$tcolor->name."\">$message</span>";
  }

} //END-Class