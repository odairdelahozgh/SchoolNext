<?php

// trait Funciones {

//   public static function getRandom() { // para pruebas !!
//     $enums = self::cases();
//     return $enums[array_rand($enums)];
//   }//END-getRandom

//   public static function allValues(): array {
//      return array_column(self::cases(), 'value');
//   }//END-allValues
  
//   public static function allNames(): array {
//     return array_column(self::cases(), 'name');
//   }//END-allValues

//   public static function forSelect(string $id): String  {
//     $opts = '';
//     foreach (self::cases() as $case) {
//       $opts .= "<option value=\"$case->value\">".$case->label()."</option>";
//     }
//     return "<select id=\"$id\" name=\"$id\">$opts</select>";
//   }//END-forOptions

// }//END-TRAIT



// enum Estado: int {
//   Use Funciones;

//   case Inactivo = 0;
//   case Activo   = 1;

//   public const Bueno = self::Activo;

//   public function label(): string {
//     return match($this) {
//       static::Inactivo => 'Inactivo',
//       static::Activo   => 'Activo',
//       default          => 'Inactivo',
//     };
//   }//END-label
  
//   public function ico(): string {
//     $ico = match($this) {
//         Estado::Inactivo => 'fa-face-frown',
//         Estado::Activo   => 'fa-face-smile',
//         default          => 'fa-face-frown',
//     };
//     return "<i class=\"fa-solid $ico w3-small\"></i>";
//   }//END-ico

//   public function color(): string {
//     return match($this) {
//         Estado::Inactivo => 'red',
//         Estado::Activo   => 'green',
//         default          => 'red',
//     };
//   }//END-color

// }//END-ENUM

// // print Estado::Inactivo->value;
// // $estado = Estado::tryFrom($Param) ?? Estado::Inactivo;

?>