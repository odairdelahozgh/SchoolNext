<?php

trait RangoTraitSetUp {
  
  use TraitUuid, TraitForms, TraitValidar;

  private function setUp() 
  {
    self::$_fields_show = [
      'all'     => ['id', 'nombre', 'lim_inf', 'lim_sup', 'color_rango', 'color_texto', 'color_backg', 'created_by', 'updated_by', 'created_at', 'updated_at'],
      'index'   => ['id', 'nombre', 'lim_inf', 'lim_sup', 'color_rango', 'color_texto', 'color_backg'],
      'create'  => ['nombre', 'lim_inf', 'lim_sup', 'color_rango', 'color_texto', 'color_backg'],
      'edit'    => ['nombre', 'lim_inf', 'lim_sup', 'color_rango', 'color_texto', 'color_backg'],
    ];
  
    self::$_attribs = [
      'id'      => 'required',
      'nombre'  => 'required',
      'lim_inf' => 'required',
      'lim_sup' => 'required',
    ];
  
    self::$_defaults = [
      'lim_inf'  => 0,
      'lim_sup'  => 0,
      'color_rango' => '',
      'color_texto' => '',
      'color_backg' => '',
    ];
  
    self::$_helps = [
      'color_rango' => 'nombre del color',
      'color_texto' => 'nombre del color',
      'color_backg' => 'nombre del color',
    ];
  
    self::$_labels = [
      'nombre'      => 'Nombre del Rango',
      'lim_inf'     => 'Límite Inferior',
      'lim_sup'     => 'Límite Superior',
      'color_rango' => 'Color del Rango',
      'color_texto' => 'Color de Texto',
      'color_backg' => 'Color de Fondo',

      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];

  }




}