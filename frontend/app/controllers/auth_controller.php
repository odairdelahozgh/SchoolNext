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
        View::template('login');
        if((new User)->login()) { Redirect::to('index'); }
    } 

    public function logout() {
      (new User)->logout();
      Redirect::toAction('login');
    }

}

