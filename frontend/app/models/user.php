<?php

class User extends ActiveRecord
{
    protected $source = 'dm_user';
      
    const IS_ACTIVE = [ 0 => 'Inactivo', 1 => 'Activo' ];
    
    public $before_delete = 'no_borrar_activos';
    public function no_borrar_activos() {
        if($this->is_active==1) {
            Flash::warning('No se puede borrar un registro activo');
            return 'cancel';
        }
    }

    public function after_delete() {
        Flash::valid("Se borró el registro $this->id");
    }

    public function before_create() { 
        $this->is_active = 1; 
    }

    public function before_save() {            
        $rs = $this->find_first("documento = $this->documento");
        if($rs) {
            Flash::warning('Ya existe un usuario registrado bajo esta cédula');
            return 'cancel';
        }                
    }

    /**
      * Devuelve TODOS los registros del modelo Salon sin paginación
      */
    public function getList() {
        return (new User)->find();
    }

   /**
      * Devuelve TODOS los registros del modelo Usuario para ser paginados
      * @param int $page  [requerido] página a visualizar
      * @param int $ppage [opcional] por defecto 20 por página
      */
    public function getUsuarios($page, $ppage=50) {
        return $this->paginate("page: $page", "per_page: $ppage", 'order: id desc');
    }

   /**
      * Devuelve los registros ACTIVOS del modelo Salon para ser paginados
      * @param int $page  [requerido] página a visualizar
      * @param int $ppage [opcional] por defecto 20 por página
      */
    public function getUsuariosActivos($page, $ppage=50) {
        return $this->paginate("page: $page", 'conditions: is_active=1' , "per_page: $ppage", 'order: id desc');
    }

   /**
      * Devuelve los registros INACTIVOS del modelo Salon para ser paginados
      * @param int $page  [requerido] página a visualizar
      * @param int $ppage [opcional] por defecto 20 por página
      */
    public function getUsuariosInactivos($page, $ppage=50) {
        return $this->paginate("page: $page", 'conditions: is_active=0' , "per_page: $ppage", 'order: id desc');
    }
    
   //=========
   public function __toString() {
    return $this->getNombreCompleto('a1 a2 n');
    }

    
    //=========
    public function getNombreCompleto2($orden='a1 a2, n', $sanear=true, $humanize=false) {
        if ($sanear) {
            $this->nombres   = OdaUtils::sanearString($this->nombres);
            $this->apellido1 = OdaUtils::sanearString($this->apellido1);
            $this->apellido2 = OdaUtils::sanearString($this->apellido2);
        }
        if ($humanize) {
            $this->nombres   = OdaUtils::nombrePersona($this->nombres);
            $this->apellido1 = OdaUtils::nombrePersona($this->apellido1);
            $this->apellido2 = OdaUtils::nombrePersona($this->apellido2);
        }
        
        return str_replace(
            array('n', 'a1', 'a2'),
            array($this->nombres, $this->apellido1, $this->apellido2),
            $orden);
    }

    //=========
    public function getNombreCompleto($orden='a1 a2, n') {
        return str_replace(
            array('n', 'a1', 'a2'),
            array($this->nombres, $this->apellido1, $this->apellido2),
            $orden);
    }


    /**
     * Iniciar sesion
     *
     */
    public function login() {
        
        $auth = Auth2Odair::factory('model'); // Obtiene el adaptador
        $auth->setModel('User'); // Modelo que utilizará para consultar
        $auth->setFields(['id', 'username', 'password', 'nombres', 'apellido1', 'apellido2', 'roll', 'documento', 'usuario_instit', 'clave_instit', 'theme']);
        $auth->setLogin('username');
        $auth->setPass('password');
        $auth->setAlgos('sha1');
        $auth->setKey('usuario_logged');
        
        
        $DoliK = new DoliConst();
        $annio_actual = $DoliK->getValue('SCHOOLNEXTCORE_ANNIO_ACTUAL');
        $periodo_actual = $DoliK->getValue('SCHOOLNEXTCORE_PERIODO_ACTUAL');
        
        Session::set('ip', OdaUtils::getIp() );
        $estePeriodo = (new Periodo)->getPeriodoActual($periodo_actual);
        Session::set('annio', (int)$annio_actual);
        Session::set('periodo',      (int)$periodo_actual);
        Session::set('fecha_inicio', $estePeriodo->fecha_inicio);
        Session::set('fecha_fin',    $estePeriodo->fecha_fin);
        Session::set('f_ini_notas',  $estePeriodo->f_ini_notas);
        Session::set('f_fin_notas',  $estePeriodo->f_fin_notas);
        Session::set('f_open_day',   $estePeriodo->f_open_day);
        Session::set('es_director',  false);
        
        if ($auth->identify()) { 
          Session::set('es_director',  (new Salon)->isDirector( (int)Session::get('id') ) );
          Session::set('foto', "uploads/users/".Session::get('documento').".png");
          return true; 
        }

        if ($auth->getError()) { 
          OdaFlash::warning($auth->getError());
        }
        return false;
    }

    /**
     * User | logout() : Terminar sesion
     */
    public function logout() {
        $auth = Auth2Odair::factory('model'); // Obtiene el adaptador
        $auth->setModel('User'); // Modelo que utilizará para consultar
        $auth->logout();
    }

    /**
     * User | logged() : Verifica si el usuario esta autenticado
     */
    public function logged(): bool {
        return Auth2Odair::factory('model')->isValid();
    }

    /**
     * User | isLogged() : Verifica si el usuario esta autenticado
     */
    public function isLogged(): bool {
      return Auth2Odair::factory('model')->isValid();
    }

}
