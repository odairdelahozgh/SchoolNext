<?php
/**
 * trait.
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source   frontend\app\extensions\helpers
 */

 enum ThemeColor : string {
  case PRIMARY = 'primary';
  case SECONDARY = 'secondary';
  case SUCCESS = 'success';
  case DANGER = 'danger';
  case WARNING = 'warning';
  case INFO = 'info';
  case LIGHT = 'light';
  case DARK = 'dark';
}

enum ThemeSize: string {
  case SM = 'sm';
  case MD = 'md';
  case LG = 'lg';
}

enum ThemeButtonType: string {
  case BUTTON = 'button';
  case SUBMIT = 'submit';
  case RESET = 'reset';
}

trait ThemeEnums {
  
}