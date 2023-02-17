<?php
/**
 * Modelo EstudianteAdjuntosDos * 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * id, estudiante_id, 
 * nombre_archivo1, coment_archivo1, estado_archivo1, 
 * nombre_archivo2, coment_archivo2, estado_archivo2, 
 * nombre_archivo3, coment_archivo3, estado_archivo3, 
 * created_at, updated_at, created_by, updated_by
 */

 
class EstudianteAdjuntosDos extends LiteRecord {

  use EstudianteAdjuntosDosTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.estud_adjuntos_dos');
    $this->setUp();
  } //END-__construct


} //END-CLASS