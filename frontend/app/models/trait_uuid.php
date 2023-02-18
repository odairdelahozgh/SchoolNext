<?php
// UUID: Universally Unique IDentifier
trait TraitUuid {

  /**
   * UUID Generator Optimized
   */
  public function UUIDReal(int $lenght=20):string {
    if ($lenght <= parent::$lim_tam_campo_uuid) {
      if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($lenght / 2));
      } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
      } else {
        throw new Exception("no cryptographically secure random function available");
      }
    } else {
      throw new Exception("lenght must be <= 36");
    }
    return substr(bin2hex($bytes), 0, $lenght);
  }//END-UUIDReal
  
  
  /**
   * Devuelve un Registro por su UUID.
   */
  public static function getByUUID(string $uuid, string $fields = '*') {
    $sql = "SELECT $fields FROM ".static::getSource().' WHERE uuid = ?';
    return static::query($sql, [$uuid])->fetch();
  }

/*   public static function get_uuid(string $uuid, string $fields = '*') {
    return self::get_uuid($uuid, $fields); // BORRAR ...se mantiene por compatiblidad.
  } */
  

  /**
   * Elimina un registro por su UUID.
   */
  public static function deleteByUUID(string $uuid): bool {
    $source  = static::getSource();
    return static::query("DELETE FROM $source WHERE uuid = ?", [$uuid])->rowCount() > 0;
  } //END-deleteUUID

/*   public static function deleteUUID(string $uuid): bool {
    return self::deleteByUUID($uuid); // BORRAR ...se mantiene por compatiblidad.
  } */

  
  /**
   * Rellena el campo UUID de todos los registros del modelo
   */
  public function setUUID_All_ojo($long=20) {
    $Todos = $this::all();
    foreach ($Todos as $reg) {
      $reg->uuid = $this->UUIDReal($long);
      $reg->update();
    }
  } //END-setUUID_All_ojo
  

} //END-TraitUuid