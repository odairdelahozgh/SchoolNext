<?php
  trait EnumsFunciones {

  public static function getRandom() { // para pruebas !!
    $enums = self::cases();
    return $enums[array_rand($enums)];
  } //END-getRandom

  public static function allValues(): array {
     return array_column(self::cases(), 'value');
  } //END-allValues
  
  public static function allNames(): array {
    return array_column(self::cases(), 'name');
  } //END-allNames

  public static function forSelect(string $id): String  {
    $opts = '';
    foreach (self::cases() as $case) {
      $opts .= "<option value=\"$case->value\">".$case->label()."</option>";
    }
    return "<select id=\"$id\" name=\"$id\">$opts</select>";
  } //END-forSelect

} // END-TRAIT
