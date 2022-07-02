<?php

/**
 * Controller por defecto si no se usa el routes
 *
 */
class AuthController extends AdminController
{
    //public $theme="w3-theme-dark-grey";

    public function index() {
        Redirect::toAction('login');
    }

    public function login() {
        $this->page_title = 'Login';
        $this->colegio_nombre   = Config::get('institucion.nombre');
        $this->soporte_telefono = Config::get('construxzion.telefono');
        $this->soporte_whatsapp = Config::get('construxzion.whatsapp');
        $this->soporte_email    = Config::get('construxzion.email');
        $this->sw_house_name    = Config::get('construxzion.name');
        $this->sw_house_twitter = Config::get('construxzion.twitter');
        $this->copy_right       = Config::get('construxzion.copy');
        $this->copy_text        = Config::get('construxzion.copy_text');
        View::template('login');
        if(Load::model('usuario')->login()) { Redirect::to('index'); }
    } 

    public function logout() {
        Load::model('usuario')->logout();
        Redirect::toAction('login');
    }

}

