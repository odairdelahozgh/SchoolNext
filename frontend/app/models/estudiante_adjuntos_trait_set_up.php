<?php
require_once VENDOR_PATH.'autoload.php';
use Respect\Validation\Validator as validar;
use Respect\Validation\Exceptions\NestedValidationException;
// https://respect-validation.readthedocs.io/en/latest/

trait EstudianteAdjuntosTraitSetUp {
  
  use TraitUuid, TraitForms, TraitSubirAdjuntos, 
      EstudianteAdjuntosTraitProps, EstudianteAdjuntosTraitCorrecciones;
  
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

  
  /**
   * CONFIGURACIÓN DEL MODELO
   */
  private function setUp() {

    $this->setRutaDestino('/files/upload/matriculas_adjuntos');
    
    self::$_fields_show = [
      'all'     => ['id', 'uuid', 'estudiante_id', 'nombre_archivo1', 'coment_archivo1', 'estado_archivo1', 'nombre_archivo2', 'coment_archivo2', 'estado_archivo2', 'nombre_archivo3', 'coment_archivo3', 'estado_archivo3', 'nombre_archivo4', 'coment_archivo4', 'estado_archivo4', 'nombre_archivo5', 'coment_archivo5', 'estado_archivo5', 'nombre_archivo6', 'coment_archivo6', 'estado_archivo6', 'created_at', 'updated_at', 'created_by', 'updated_by'],
      'index'   => ['id', 'uuid', 'estudiante_id', 'estado_archivo1', 'estado_archivo2', 'estado_archivo3', 'estado_archivo4', 'estado_archivo5', 'estado_archivo6'],
      'create'  => ['estudiante_id', 'nombre_archivo1', 'nombre_archivo2', 'nombre_archivo3', 'nombre_archivo4',  'nombre_archivo5', 'nombre_archivo6', ],
      'edit'    => ['nombre_archivo1', 'estado_archivo1', 'nombre_archivo2', 'estado_archivo2', 'nombre_archivo3',  'estado_archivo3', 'nombre_archivo4', 'estado_archivo4', 'nombre_archivo5', 'estado_archivo5', 'nombre_archivo6', 'estado_archivo6']
    ];
  
    self::$_attribs = [
      'estudiante_id'       => 'required',
      'nombre_archivo1'  => 'accept="image/*,.pdf"',
      'nombre_archivo2'  => 'accept="image/*,.pdf"',
      'nombre_archivo3'  => 'accept="image/*,.pdf"',
      'nombre_archivo4'  => 'accept="image/*,.pdf"',
      'nombre_archivo5'  => 'accept="image/*,.pdf"',
      'nombre_archivo6'  => 'accept="image/*,.pdf"',
    ];
    
    self::$_defaults = [
    ];
  
    self::$_helps = [
      'nombre_archivo1'  => 'subir acá '.Config::get('matriculas.file_1_titulo'),
      'nombre_archivo2'  => 'subir acá '.Config::get('matriculas.file_2_titulo'),
      'nombre_archivo3'  => 'subir acá '.Config::get('matriculas.file_3_titulo'),
      'nombre_archivo4'  => 'subir acá '.Config::get('matriculas.file_4_titulo'),
      'nombre_archivo5'  => 'subir acá '.Config::get('matriculas.file_5_titulo'),
      'nombre_archivo6'  => 'subir acá '.Config::get('matriculas.file_6_titulo'). '<br>--> solo para los grados 9°, 10° y 11°',
    ];
  
    self::$_labels = [
      'nombre_archivo1'  => 'Archivo 1: '.Config::get('matriculas.file_1_titulo'),
      'nombre_archivo2'  => 'Archivo 2: '.Config::get('matriculas.file_2_titulo'),
      'nombre_archivo3'  => 'Archivo 3: '.Config::get('matriculas.file_3_titulo'),
      'nombre_archivo4'  => 'Archivo 4: '.Config::get('matriculas.file_4_titulo'),
      'nombre_archivo5'  => 'Archivo 5: '.Config::get('matriculas.file_5_titulo'),
      'nombre_archivo6'  => 'Archivo 6: '.Config::get('matriculas.file_6_titulo'),

      'coment_archivo1' => 'Título o contenido del archivo 1',
      'coment_archivo2' => 'Título o contenido del archivo 2',
      'coment_archivo3' => 'Título o contenido del archivo 3',
      'coment_archivo4' => 'Título o contenido del archivo 4',
      'coment_archivo5' => 'Título o contenido del archivo 5',
      'coment_archivo6' => 'Título o contenido del archivo 6',

      'estado_archivo1' => 'Estado de Revisión para '.Config::get('matriculas.file_1_titulo'),
      'estado_archivo2' => 'Estado de Revisión para '.Config::get('matriculas.file_2_titulo'),
      'estado_archivo3' => 'Estado de Revisión para '.Config::get('matriculas.file_3_titulo'),
      'estado_archivo4' => 'Estado de Revisión para '.Config::get('matriculas.file_4_titulo'),
      'estado_archivo5' => 'Estado de Revisión para '.Config::get('matriculas.file_5_titulo'),
      'estado_archivo6' => 'Estado de Revisión para '.Config::get('matriculas.file_6_titulo'),

      'created_at'      => 'Creado el',
      'created_by'      => 'Creado por',
      'updated_at'      => 'Actualizado el',
      'updated_by'      => 'Actualizado por',
    ];
  
    self::$_placeholders = [
      'coment_archivo1'  => Config::get('matriculas.file_1_titulo'),
      'coment_archivo2'  => Config::get('matriculas.file_2_titulo'),
      'coment_archivo3'  => Config::get('matriculas.file_3_titulo'),
      'coment_archivo4'  => Config::get('matriculas.file_4_titulo'),
      'coment_archivo5'  => Config::get('matriculas.file_5_titulo'),
      'coment_archivo6'  => Config::get('matriculas.file_6_titulo'),
    ];

  }
  
} //END-SetUp