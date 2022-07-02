<?php
/**
  * Modelo CargaProfesor  
  * @category App
  * @package Models 
  */
class TempProfesor extends LiteRecord
{
    protected static $table = 'temp';
    protected static $nomt_estud='sweb_estudiantes';

    public function getCarga() {
        return $this->data = $this::all();
    }


    
}