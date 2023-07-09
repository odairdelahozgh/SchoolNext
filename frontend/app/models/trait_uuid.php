<?php
trait TraitUuid {
  
  /**
   * UUID Generator Optimized
   * UUID: Universally Unique IDentifier
   */
  public function UUIDReal(int $lenght=36): string {
    if ($lenght <= parent::$lim_tam_campo_uuid) {
      if (function_exists("random_bytes")) {
        $bytes = random_bytes(ceil($lenght / 2));
      } elseif (function_exists("openssl_random_pseudo_bytes")) {
        $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
      } else {
        throw new Exception("no cryptographically secure random function available");
      }
    } else {
      throw new Exception('lenght must be <= '.parent::$lim_tam_campo_uuid);
    }
    return substr(bin2hex($bytes), 0, $lenght);
  }//END-UUIDReal
  
  public function setUUID(int $lenght=20) {
    $this->uuid = $this->UUIDReal($lenght); // Asigna un numero UUID
  } //END-setUUID
  
  public static function getByUUID(string $uuid, string $fields = '*') {
    $sql = "SELECT $fields FROM ".static::getSource().' WHERE uuid = ?';
    return static::query($sql, [$uuid])->fetch(); // Devuelve un Registro por su UUID.
  } //END-getByUUID

  public static function deleteByUUID(string $uuid): bool {
    $source  = static::getSource(); // Elimina un registro por su UUID.
    return static::query("DELETE FROM $source WHERE uuid = ?", [$uuid])->rowCount() > 0;
  } //END-deleteByUUID


  public function setUUID_All_ojo(int $long=20) { // Instancia UUID de todos
  $Todos = $this::all();
  foreach ($Todos as $reg) {
    
    $uuid = $this->UUIDReal($long);
    $reg->update(['uuid'=>$uuid, 'is_active'=>1]);
    //}
  }

  } //END-setUUID_All_ojo


} //END-TraitUuid