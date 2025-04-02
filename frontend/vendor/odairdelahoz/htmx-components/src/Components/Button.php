<?php

namespace HtmxComponents\Components;

use HtmxComponents\Traits\HtmxAttributes;
use HtmxComponents\Enums\BootstrapGeneralStyle;
use HtmxComponents\Enums\BootstrapButtonStyle;

class Button extends BaseComponent
{
  use HtmxAttributes;

  public function __construct(
    private string $label, 
    array $styles = [], 
    array $attributes = [], 
  )
  {
    parent::__construct($attributes, $styles);
  }

  public function render(): string
  {
    $attributes = $this->renderAttributes();
    $styles = $this->renderStyles();
    return "<button type=\"button\" class=\"btn $styles\" $attributes>{$this->label}</button>";
  }
  
}