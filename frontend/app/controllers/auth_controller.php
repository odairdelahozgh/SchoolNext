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
        $this->colegio_nombre   = Config::get('config.institution.nombre');
        $this->soporte_telefono = Config::get('config.construxzion.telefono');
        $this->soporte_whatsapp = Config::get('config.construxzion.whatsapp');
        $this->soporte_email    = Config::get('config.construxzion.email');
        $this->sw_house_name    = Config::get('config.construxzion.name');
        $this->sw_house_twitter = Config::get('config.construxzion.twitter');
        $this->copy_right       = Config::get('config.construxzion.copy');
        $this->copy_text        = Config::get('config.construxzion.copy_text');
        View::template('login');
        if(Load::model('user')->login()) { Redirect::to('index'); }
    } 

    public function logout() {
        Load::model('user')->logout();
        Redirect::toAction('login');
    }

}

