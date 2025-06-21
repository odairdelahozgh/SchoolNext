<?php

namespace App\Components\Bootstrap5;
use Exception;

abstract class BtComponent
{
    protected array $attributes = [];
    protected array $classes = [];
    

    public function __construct(
      protected string $componentName, 
      protected string $id = '')
    {
      $this->componentName = $componentName;
      $this->id = $id;
    }

    public function addClass(string $class): self
    {
        $this->classes[] = $class;
        return $this;
    }

    public function addAttribute(string $name, string $value): self
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    public function addStyle(string $style): self
    {
        $this->attributes['style'] = $style;
        return $this;
    }

    public function render(): string
    {
        return $this->getTemplate();
    }

    protected function getTemplate(): string
    {
        // Implementación específica para cada componente
        throw new Exception('Método getTemplate no implementado');
    }

    protected function getDataAttributes(): string
    {
        return count($this->attributes) > 0 
            ? ' ' . implode(' ', array_map(fn($k, $v) => "$k=\"$v\"", array_keys($this->attributes), $this->attributes))
            : '';
    }

    protected function getClasses(): string
    {
        return count($this->classes) > 0 
            ? ' class="' . implode(' ', $this->classes) . '"' 
            : '';
    }
}