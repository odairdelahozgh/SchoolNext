<?php

/**
 * Controller por defecto si no se usa el routes
 *
 */
class IndexController extends AppController
{
    const MODULOS = array(
            'admin'         => 'admin', 
            'docentes'      => 'docentes', 
            'coordinadores' => 'docentes', 
            'padres'        => 'padres', 
            'secretarias'   => 'secretaria', 
            'sicologos'     => 'sicologia', 
            'contables'     => 'contabilidad', 
            'enfermeras'    => 'enfermeria'
        );
    
    public function index() {
        $roll_usuario = strtolower(trim(Session::get('roll')));
        if ( !array_key_exists($roll_usuario, self::MODULOS) ) {
            $this->logout();
        }
        Session::set('modulo', self::MODULOS[$roll_usuario] );
        Redirect::to(Session::get('modulo'));
    }


    public function logout() {
        Load::model('User')->logout();
        Redirect::toAction('login');
    }

}
