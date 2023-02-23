<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait RegistrosGenTraitSetUp {
  
  use TraitUuid, TraitForms;

  public function validar($input_post) {
    Session::set('error_validacion', '');
    try{
      //validar::number()->length(1)->min(0)->max(1)->assert($input_post['is_active']);
      return true;
    } catch(NestedValidationException $exception) {
      Session::set('error_validacion', $exception->getFullMessage());
      return false;
    }
  } //END-validar

  // ===========
  public function getFecha($date_format="d-M-Y") {
    return date($date_format, strtotime($this->fecha));
  } // END-getFecha
  
  // ===========
  public function getFotoAcudiente() {
    //if (!$this->foto_acudiente) { return 'no foto_acudiente'; }
    $filename = 'estud_reg_observ_gen/'.$this->foto_acudiente;
    return OdaTags::fileimg($filename, "class=\"w3-round\" style=\"width:100%;max-width:80px\"");
  } // END-getFotoAcudiente
  
  // ===========
  public function getFotoDirector() {
    if (!$this->foto_director) { return 'no foto_director'; }
    $filename = 'estud_reg_observ_gen/'.$this->foto_director;
    return OdaTags::fileimg($filename, "class=\"w3-round\" style=\"width:100%;max-width:80px\"");
  } // END-getFotoDirector

  
  /**
   * CONFIGURACIÓN DEL MODELO
   */
  private function setUp() {

    self::$_fields_show = [
      'all'       => ['id', 'uuid', 'tipo_reg', 'estudiante_id', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'fecha', 'asunto', 'acudiente', 'foto_acudiente', 'director', 'foto_director', 
                    'created_at', 'updated_at', 'created_by', 'updated_by'],
      'index'     => ['tipo_reg', 'estudiante_id', 'annio', 'periodo_id', 'grado_id', 'salon_id', 'fecha', 'asunto'],
      'create'    => ['tipo_reg', 'periodo_id', 'fecha', 'asunto', 'acudiente', 'director'],
      'edit'      => ['tipo_reg', 'periodo_id', 'fecha', 'asunto', 'acudiente', 'foto_acudiente', 'director', 'foto_director'],
      'editUuid'  => ['tipo_reg', 'periodo_id', 'fecha', 'asunto', 'acudiente', 'foto_acudiente', 'director', 'foto_director'],
    ];
  
    self::$_attribs = [
      'tipo_reg'        => 'required',
      'estudiante_id'   => 'required',
      'annio'           => 'required',
      'periodo_id'      => 'required',
      'grado_id'        => 'required',
      'salon_id'        => 'required',
      'asunto'          => 'required',
      'fecha'           => 'required',
      'acudiente'       => 'required',
      'director'        => 'required',

      'id'                => 'required',
      'uuid'              => 'required',
    ];
  
    self::$_defaults = [
    ];
  
    self::$_helps = [
      'asunto'=>'L&iacute;mite: 1024 caracteres', 
      'acudiente'=>'Nombre del Acudiente que Asisti&oacute; a la reuni&oacute;n',
      'foto_acudiente'=>'Evidencia Acudiente. Archivo tipo imagen [jpg, png, gif, jpeg]',
      'director'=>'Nombre del Director de grupo o Profesor que organiz&oacute;',
      'foto_director'=>'Evidencia Docente. Archivo tipo imagen [jpg, png, gif, jpeg]',
    ];
  
    self::$_labels = [
      'tipo_reg'=>'Tipo Registro',
      'estudiante_id'=>'Estudiante',
      'annio'=>'A&nacute;o', 
      'periodo_id'=>'Periodo',
      'grado_id'=>'Grado', 
      'salon_id'=>'Sal&oacute;n',
      'fecha'=>'Fecha de Registro', 
      'asunto'=>'Asunto', 
      'acudiente'=>'Acudiente', 
      'foto_acudiente'=>'Evidencia', 
      'director'=>'Director', 
      'foto_director'=>'Evidencia',
      
      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
    ];
  
  }//END-setUp


} //END-SetUp