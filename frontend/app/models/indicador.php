<?php
/**
  * Modelo Indicadores
  * @category App
  * @package Models 
  * @example annio, periodo_id, grado_id, asignatura_id, codigo, concepto, valorativo, is_visible, is_active, created_at, updated_at, created_by, updated_by
  * https://github.com/KumbiaPHP/ActiveRecord
  */
class Indicador extends LiteRecord
{
    protected static $table = 'sweb_indicadores';
    
    const IS_visible = [
        0 => 'No visible',
        1 => 'Visible'
    ];

    //=========
    public function getIndicadores(int $asignatura_id, int $grado_id, int $annio) {
      // $annio--- para los históricos
      $DQL = " SELECT * FROM " . self::$table
           . " WHERE asignatura_id=? AND grado_id=? "
           . " ORDER BY annio, periodo_id, codigo ";
      return (new Indicador)->all($DQL, array($asignatura_id, $grado_id));
    } // END-getList

    
    // =============
    public function getByPk($pk, $fields='*') {
      return $this->data = $this::get($pk, $fields = '*');
    }

    //=========
    public function __toString() {
       return $this->id.': ' .$this->nombre;
    } // END-toString

}