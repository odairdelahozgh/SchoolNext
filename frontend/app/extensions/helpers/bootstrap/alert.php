<?php
/**
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source   frontend\app\extensions\helpers
 * 
 */

class Alert {
  
  public static function getAlert(
    string $message, 
    ThemeColor $color = ThemeColor::PRIMARY, 
    $has_icon=true): string 
  {
    $has_icon = ($has_icon)?'has-icon':'';
    $btn_close = '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>';
    return "<div class=\"alert alert-{$color->value} $has_icon\" role=\"alert\">$message $btn_close</div>";
  }


}