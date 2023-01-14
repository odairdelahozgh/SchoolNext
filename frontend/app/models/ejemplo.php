<?php

/**
  * Modelo de Ejemplo  
  * @category App
  * @package Models 
  * https://github.com/KumbiaPHP/Documentation/blob/master/es/active-record.md
  */
  
  
  //  CALLBACKS:
  //_beforeCreate, _afterCreate, _beforeUpdate, _afterUpdate, _beforeSave, _afterSave 
  
  // PROPIEDADES
  // ::class,  ::getTable(), ::getDriver()
  

  // crear registro:         ->create(array $data = []): bool {}
  // actualizar registro:      ->update(array $data = []): bool {}
  // Guardar registro:       ->save(array $data = []): bool {}
  // Eliminar registro por pk:   ::delete($pk): bool
  //
  // Averigua si existe registro      ::exists($pk): bool
  // Buscar por clave pk:         ::get($pk, $fields = '*')
  // Todos los registros:         ::all(string $sql = '', array $values = []): array {}
  // Primer registro de la consulta sql:  ::first(string $sql, array $values = [])//: static in php 8
  // Filtra las consultas         ::filter(string $sql, array $values = []): array


class Ejemplo extends LiteRecord
{
  protected static $table = 'sweb_ejemplo';
  
  const TIPO = [
    1 => 'Apartamento',
    2 => "Estudio"
  ];

  public function __toString() { return $this->nombre; }

  
	public function paginateCustomers(int $page = 1, int $perPage = 50): Paginator
	{
		$sql = 'SELECT * FROM ' . self::getSource() . ' WHERE status = ?';
		return self::paginateQuery($sql, $page, $perPage, [1]);
	}
}