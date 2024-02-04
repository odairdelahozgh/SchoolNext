<?php
/**
 * trait.
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source   frontend\app\extensions\helpers
 */

 class Badge {
  
  public static function badge(
    string $message, 
    ThemeColor $tcolor=ThemeColor::PRIMARY, 
    $pill =false, 
    $bg_light=false): string 
  {
    $class_pill = ($pill)?'badge-pill':'';
    $class_bg_light = ($bg_light)?'badge-subtle':'';
    return "<span class=\"badge $class_bg_light $class_pill badge-".$tcolor->value."\">$message</span>";
  }


}