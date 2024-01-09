<?php
trait TraitUuid {
  
  /**
   * UUID Generator Optimized
   */
  public function UUIDReal(int $lenght=36): string 
  {
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
  }
  
  /**
   * Devuelve un valor hash, método xxh3
   */
  public function xxh3Hash(): string 
  {
    $data = date('ymdhis').rand(1, 1000);
    return hash("xxh3", $data, options: ["seed" => rand(1, 1000)]);
  }

  /**
   * Guarda el valor gnerado con hash(xxh3) en el campo uuid del registro actual
   */
  public function setHash(): void 
  {
    $this->uuid = $this->xxh3Hash();
  }

  /**
   * Guarda el valor gnerado con UUIDReal() en el campo uuid del registro actual
   */
  public function setUUID(int $lenght=20): void 
  {
    $this->uuid = $this->UUIDReal($lenght);
  }

  /**
   * Devuelve un Registro por su UUID.
   */
  public static function getByUUID(string $uuid, string $fields = '*') 
  {
    $sql = "SELECT $fields FROM ".static::getSource().' WHERE uuid = ?';
    return static::query($sql, [$uuid])->fetch();
  }

  /**
   * Elimina un Registro por su UUID.
   */
  public static function deleteByUUID(string $uuid): bool 
  {
    $source  = static::getSource();
    return static::query("DELETE FROM $source WHERE uuid = ?", [$uuid])->rowCount() > 0;
  } //END-deleteByUUID

  /**
   * @deprecated 
   */
  public function setUUID_All_ojo(int $long=20) 
  {
    try {
      $Todos = $this::all();
      $RG = new RegistrosGen();
      $DQL = new OdaDql($RG);
      
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
  }

  /**
   * @deprecated 
   */
  public function setUUID_All($tabla) 
  {
    try {
    } catch (\Throwable $th) {
      OdaFlash::error($th);
    }
  }


} //END-TraitUuid