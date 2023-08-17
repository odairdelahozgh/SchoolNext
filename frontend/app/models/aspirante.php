<?php
/**
 * Modelo Aspirante  
 * @author   ConstruxZion Soft (odairdelahoz@gmail.com).
 * @category App
 * @package  Models https://github.com/KumbiaPHP/ActiveRecord
 * 
 * id, extra, fecha_insc, estatus, is_active, is_trasladado, is_pago, is_habeas_data,
 * nombres, apellido1, apellido2, documento, tipo_dcto, sexo, fecha_nac, 
 * pais_nac, depto_nac, ciudad_nac, direccion, barrio, telefono1, telefono2, 
 * grado_aspira, ante_instit, ante_instit_dir, ante_instit_tel, 
 * ante_grado, ante_fecha_ret, tiempoinstit, 
 * madre, madre_id, madre_prof, madre_empresa, madre_cargo, madre_tel_ofi, 
 * madre_tel_per, madre_email, madre_edad, 
 * padre, padre_id, padre_prof, padre_empresa, padre_cargo, padre_tel_ofi, 
 * padre_tel_per, padre_email, padre_edad, 
 * 1_colegio, 1_ciudad, 1_telefono, 1_grados, 1_annios, 1_motivo_ret, 
 * 2_colegio, 2_ciudad, 2_telefono, 2_grados, 2_annios, 2_motivo_ret, 
 * 3_colegio, 3_ciudad, 3_telefono, 3_grados, 3_annios, 3_motivo_ret, 
 * razones_cambio, observaciones, fecha_eval, fecha_entrev, 
 * result_matem, result_caste, result_ingle, result_socia, result_scien, 
 * result_pmate, result_plect, 
 * entrevista, recomendac, is_fecha_entrev, is_fecha_eval, ctrl_llamadas, 
 * created_by, created_at, updated_by, updated_at
 * 
 * 
 * ASPIRANTE-PSICO
 * id, aspirante_id, extra, vive_con, desfisico, lenguaje, aprendizaje, 
 * comporta, afecto, relhermanos, relpadres, antecfami, manejoautor, 
 * relpares, reldocentes, fortalezas, reforzar, cumplnormas, 
 * nucleofamil, autocuidado, especialista, proceso_acad, 
 * porquedesea, rel_pad_mad, rel_pad_mad_desc
 * created_at, updated_at, created_by, updated_by, 
 * 
 */
  
class Aspirante extends LiteRecord {
  use AspiranteTraitSetUp;
  
  public function __construct() {
    try {
      parent::__construct();
      self::$table = Config::get('tablas.aspirante');
      self::$_order_by_defa = 't.estatus,t.apellido1,t.apellido2,t.nombres';
      $this->setUp();
      } catch (\Throwable $th) {
        OdaFlash::error($th);
      }
    } //END-__construct
  


} //END-CLASS