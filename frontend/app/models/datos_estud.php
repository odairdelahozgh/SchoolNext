<?php
/**
 * Modelo DatosEstud 
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * 'id', 'estudiante_id', 'pais_nac', 'depto_nac', 'ciudad_nac', 'religion', 
 * 'madre', 'madre_id', 'madre_dir', 'madre_tel_1', 'madre_tel_2', 'madre_email', 'madre_ocupa', 'madre_lugar_tra', 'madre_tiempo_ser', 
 * 'padre', 'padre_id', 'padre_dir', 'padre_tel_1', 'padre_tel_2', 'padre_email', 'padre_ocupa', 'padre_lugar_tra', 'padre_tiempo_ser', 
 * 'tipo_acudi', 'parentesco', 'acudiente', 'acudi_id', 'acudi_dir', 'acudi_tel_1', 'acudi_tel_2', 'acudi_email', 'acudi_ocupa', 'acudi_lugar_tra', 
 * 'ante_instit', 'ante_instit_dir', 'ante_grado', 'ante_fecha_ret', 'ante_instit_tel', 
 * 'grupo_sang', 'salud_eps', 'salud_antec_med_fam', 'salud_alergico', 'salud_cirugias', 'salud_enfermedades', 
 * 'salud_tratamientos', 'salud_trastornos_alim', 'salud_medicam_prohibi', 'salud_aliment_prohibi', 'salud_comentarios', 
 * 'deudor', 'codeudor', 'codeudor_cc', 'resp_pago_ante_dian', 
 * 'observacion', 
 * 'created_at', 'created_by', 'updated_at', 'updated_by'
 */

class DatosEstud extends LiteRecord {

  use DatosEstudTraitSetUp, DatosEstudTraitProps;

  public function __construct() {
    parent::__construct();
    self::$table = Config::get('tablas.datosestud');
    $this->setUp();
  } //END-__construct


} //END-CLASS