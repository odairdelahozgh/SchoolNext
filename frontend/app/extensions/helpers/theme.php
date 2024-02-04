<?php
/**
 * Theme: Helper.
 * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category Helper.
 * @source   frontend\app\extensions\helpers
 */

require __DIR__.'/bootstrap/alert.php';
//require __DIR__.'/bootstrap/base.php';
require __DIR__.'/bootstrap/theme_enums.php';

class Theme extends Tag {
  
  use ThemeEnums; //, Base;

  private string $html = '';

  public function __construct(
    private ThemeColor $color = ThemeColor::PRIMARY, 
    private ThemeSize $size = ThemeSize::MD, 
    private string $additionalClasses = ''
  )  {}

  public function __toString() 
  {
    return $this->html;
  }

  function setColor(ThemeColor $color): void 
  {
    $this->color = $color;
  }

  function setSize(ThemeSize $size): void 
  {
    $this->size = $size;
  }

  public function addAlert(
    string $message, 
    ThemeColor $color = ThemeColor::PRIMARY) 
  {
    $a = new Alert();
    $this->html .= $a->getAlert($message, $color);
    return $this;
  }

}