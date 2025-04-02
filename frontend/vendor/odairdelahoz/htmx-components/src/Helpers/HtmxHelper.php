<?php
namespace HtmxComponents\Helpers;

use HtmxComponents\Enums\BootstrapButtonStyle;
use HtmxComponents\Enums\BootstrapGeneralStyle;

use HtmxComponents\Components\Button;
use HtmxComponents\Components\Modal;
use HtmxComponents\Components\Form;
use HtmxComponents\Components\Table;

class HtmxHelper
{

  public static function button(
    string $label = __FUNCTION__, 
    array $styles = [
      BootstrapButtonStyle::BUTTON_PRIMARY,
      BootstrapButtonStyle::BUTTON_LARGE
    ], 
    array $attributes = [], 
  ): Button
  {
    return new Button($label, $styles, $attributes);
  }

  public static function buttonOutline(
    string $label = __FUNCTION__, 
    array $styles = [ BootstrapButtonStyle::BUTTON_OUTLINE_PRIMARY,
    BootstrapButtonStyle::BUTTON_LARGE,
   ], 
    array $attributes = [], 
  ): Button
  {
    return new Button($label, $styles, $attributes);
  }

  public static function modal(
    string $content, 
    array $attributes = []
  ): Modal
  {
    return new Modal($content, $attributes);
  }

  public static function form(
    string $action, 
    string $method = 'POST', 
    string $content = '', 
    array $attributes = []
  ): Form
  {
    return new Form($action, $method, $content, $attributes);
  }

  public static function table(
    array $headers, 
    array $rows, 
    array $attributes = []
  ): Table
  {
    return new Table($headers, $rows, $attributes);
  }
  
}