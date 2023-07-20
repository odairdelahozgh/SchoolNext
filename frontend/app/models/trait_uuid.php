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
  

  public function xxh3Hash(): string {
    try {
      $data = date('ymdhis');
      return hash("xxh3", $data, options: ["seed" => $this->id]);
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-xxh3Hash

  public function setHash(): void {
    $this->uuid = $this->xxh3Hash();
  } //END-setHash

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
    try {
      $Todos = $this::all();
      $RG = new RegistrosGen();
      
      $DQL = new OdaDql($RG);
      OdaLog::debug($DQL);
      
      // foreach ($Todos as $reg) {
      //   $new_uuid = $this->UUIDReal($long);
      //   if ( is_null($reg->uuid) or (0==strlen($reg->uuid)) ) { 
      //     $DQL->update(['uuid'=>$new_uuid])
      //     ->where('t.id=?', $reg->id)
      //     //->execute(true)
      //     ;
      //     OdaLog::debug(self::$class_name .$DQL);
      //   }
      // }
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-setUUID_All_ojo


  public function setUUID_All($tabla) { // Instancia UUID de todos
    try {
      
    
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  } //END-setUUID_All_ojo



} //END-TraitUuid