<?php
/**
 * Modelo RegistrosDesemp * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 */

 /* 
  // ->create(array $data = []): bool {}
  // ->update(array $data = []): bool {}
  // ->save(array $data = []): bool {}
  // ::delete($pk): bool
  //
  // ::get($pk, $fields = '*')
  // ::all(string $sql = '', array $values = []): array
  // ::first(string $sql, array $values = []): static
  // ::filter(string $sql, array $values = []): array
*/
  
class RegistrosDesemp extends LiteRecord {

  use RegistrosDesempTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.estud_reg_academ');
    $this->setUp();
  } //END-__construct


  public function cambiarSalonEstudiante(int $salon_id, int $estudiante_id) {
    try {
      $RegSalon = (new Salon)->first("SELECT id, grado_id FROM ".Config::get('tablas.salones')." WHERE id=?", [$salon_id]);
      $this::query("UPDATE ".Config::get('tablas.estud_reg_academ')." SET salon_id=?, grado_id=? WHERE estudiante_id = ?", [$salon_id, $RegSalon->grado_id, $estudiante_id])->rowCount() > 0;
    } catch (\Throwable $th) {
      OdaLog::error($th);
    }
  } //END-cambiarSalonEstudiante
  

} //END-CLASS