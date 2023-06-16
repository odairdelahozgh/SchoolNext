<?php

/**
 * Controller por defecto si no se usa el routes
 *
 */
class AuthController extends AdminController
{
    //public $theme="w3-theme-dark-grey";

    public function index(): void {
        Redirect::toAction(action: 'login');
    }

    public function login(): void {
        $this->page_title = 'Login';
        View::template(template: 'login');
        if((new User)->login()) { Redirect::to(route: 'index'); }
    } 

    public function logout(): void {
      (new User)->logout();
      Redirect::toAction(action: 'login');
    }

}

