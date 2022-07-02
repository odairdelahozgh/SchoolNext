<?php
/**
  * Modelo CargaProfesor  * @category App
  * @package Models 
  */
class CargaProfesor extends LiteRecord
{
    protected static $table = 'sweb_salon_asignat_profesor';
    
    //protected function initialize() { }

    public function before_create() { }
    public function __toString() { return $this->id; }
    
    // =============
    public function getList() {
        return $this->data = $this::all();
    }

    // =============
    public function getCarga($user_id) {
        $DQL = "SELECT sap.*, s.grado_id, 
                    s.nombre as salon, a.nombre as asignatura, 
                    s.tot_estudiantes as tot_estud
                   FROM ".self::$table." as sap
                        LEFT JOIN ".Config::get('tablas.salon')." as s ON sap.salon_id=s.id  
                        LEFT JOIN ".Config::get('tablas.asign')." as a ON sap.asignatura_id=a.id
                        LEFT JOIN ".Config::get('tablas.grado')." as g ON s.grado_id=g.id
                   WHERE s.is_active=1";
        if ($user_id<>1) {
            $DQL .= " AND sap.user_id=$user_id";
        }
        $DQL .= " ORDER BY s.position, a.nombre";
        return $this::all($DQL);
    }

    // =============
    public function getSalonesCarga($user_id) {
        $DQL = "SELECT salon_id FROM ".Config::get('tablas.sap');
        if ($user_id<>1) {
            $DQL .= " WHERE user_id=$user_id ";
        }
        return $this::all($DQL);
    }

    // =============
    public function getByPk($pk, $fields='*') {
        return $this->data = $this::get($pk, $fields = '*');
    }

    // =============
    public function deleteByPk($pk) {
        if($this->is_active==1) { return false; }
        return $this::delete($pk);
    }


}