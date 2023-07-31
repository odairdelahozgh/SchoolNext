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

/*
  enum Suit: string {
    case Clubs = '♣';
    case Diamonds = '♦';
    case Hearts = '♥';
    case Spades = '♠';
  }
  // ****************************
  $clubs = Suit::from('♥');
  var_dump($clubs); // enum(Suit::Hearts)
  echo $clubs->name; // "Hearts";
  echo $clubs->value; // "♥"
  // ****************************
  echo Suit::Clubs->name; // "Clubs"
  echo Suit::Clubs->value; // "♣"
  // ****************************
  Suit::cases();
  //->>  [Suit::Clubs, Suit::Diamonds, Suit::Hearts, Suit::Spaces]
  // ****************************
  $clubs = Suit::tryFrom('not-existing');
  var_dump($clubs); // null
  // ****************************
  serialize(Suit::Clubs); ->> 'Suit:Clubs'

 */
