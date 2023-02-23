<?php
/**
 *
 * Librería para el manejo de auditorías y registro de acciones de usuarios
 *
 * @category    
 * @package     Libs
 */

class OdaUpload extends Upload {

  protected static string $subcarpeta = '';
  protected static string $id_reg = '';

  public function setSubcarpeta($subcarpeta) {
      $this->subcarpeta = trim($subcarpeta);
  }

  public function setIdreg($id) {
    $this->id_reg = trim($id);
  }

  protected function _saveFile($name) {
    
  }
  
  public function save($name = '') {

        // Genera el nombre de archivo
        $name = md5(time()).rand(1,100);

        // Guarda el archivo
        if ($this->save(self::$subcarpeta.'/'.self::$id_reg.'_'.$name)) {
            return $name . $this->_getExtension();
        }

        return FALSE;
  }

}