<?php
/**
 * Modelo EstudianteAdjuntos 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * id	estudiante_id	
 * nombre_archivo1	coment_archivo1	estado_archivo1	
 * nombre_archivo2	coment_archivo2	estado_archivo2	
 * nombre_archivo3	coment_archivo3	estado_archivo3	
 * nombre_archivo4	coment_archivo4	estado_archivo4	
 * nombre_archivo5	coment_archivo5	estado_archivo5	
 * nombre_archivo6	coment_archivo6	estado_archivo6	
 * created_at	updated_at	created_by	updated_by
 */
  
class EstudianteAdjuntos extends LiteRecord {

  use EstudianteAdjuntosTraitSetUp;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.estud_adjuntos');
    $this->setUp();
  } //END-__construct


} //END-CLASS