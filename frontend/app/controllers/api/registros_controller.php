<?php
/**
  * Controlador ESTUDIANTES  
  * @category API
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  * @author odairdelahoz@gmail.com
  * 
  */
class RegistrosController extends RestController
{

   /**
    * Obtiene todos los registros de estudiantes
    * @link http://username:password@schoolnext.local.com/api/estudiantes/all
    */
   public function get_all() {
      //$this->data = (new Nota())->all();
   }

   /**
    * Devuelve el estudiante buscado por UUID
    * @link http://username:password@schoolnext.local.com/api/estudiantes/singleuuid/3b22fefc7f6afa79c54f
    */
   public function get_singleuuid(string $uuid) {
      /*
      $record = (new Nota())->get_uuid($uuid);
      if (isset($record)) {
         $this->data = $record;
      } else {
         $this->error('El registro buscado no existe', 404);
      }
      */
   }

   /**
    * Devuelve el estudiante buscado por ID
    * @link http://username:password@schoolnext.local.com/api/estudiantes/singleid/775
    */
    public function get_singleid(int $id) {
      /*
      $record = (new Nota())->get_id($id);
      if (isset($record)) {
         $this->data = $record;
      } else {
         $this->error('El registro buscado no existe', 404);
      }
      */
   }

   
   /**
    * Devuelve el estudiante buscado por ID
    * @link http://username:password@schoolnext.com/api/registros/annio/2021
    */
   public function get_reg_observ_annio(int $annio) {
      $registros = (new RegistrosGen())->getRegistrosAnnio($annio);
      foreach ($registros as $reg) {
         $this->data["$reg->salon;$reg->salon_id"]["$reg->estudiante;$reg->estudiante_id"][$reg->periodo_id] = $reg;
      }
      /*
      $this->data = (new RegistrosGen())->getRegistrosAnnio($annio);
      */
   }

}