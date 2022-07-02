<?php

/**
  * Modelo de Ejemplo  
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
  */
  
  /*  CALLBACKS:
  _beforeCreate, _afterCreate, _beforeUpdate, _afterUpdate, _beforeSave, _afterSave */
  
  // crear registro:               ->create(array $data = []): bool {}
  // actualizar registro:          ->update(array $data = []): bool {}
  // Guardar registro:             ->save(array $data = []): bool {}
  // Eliminar registro por pk:     ::delete($pk): bool
  //
  // Buscar por clave pk:                 ::get($pk, $fields = '*') $fields: campos separados por coma
  // Todos los registros:                 ::all(string $sql = '', array $values = []): array {}
  // Primer registro de la consulta sql:  ::first(string $sql, array $values = [])//: static in php 8
  // Filtra las consultas                 ::filter(string $sql, array $values = []): array

class Test extends LiteRecord
{
  protected static $table = 'snxt_test';
  public function __toString() { return $this->descripcion; }

}