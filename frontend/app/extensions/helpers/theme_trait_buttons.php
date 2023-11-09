<?php
/**
 * trait.
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source   frontend\app\extensions\helpers
 */

trait ThemeTraitButtons {
  public static function button(
    string $caption='button',  
    ThemeColor $btn_type=ThemeColor::primary, 
    bool $disabled=false,
    bool $outline = false,
    ): string {

    $prop_disabled = ($disabled) ? 'disabled' : '' ;
    $prop_outline = ($outline) ? '-outline' : '' ;
    return "<button type=\"button\" class=\"btn btn$prop_outline-$btn_type->name\" $prop_disabled>$caption</button>";
  }


} //END-trait