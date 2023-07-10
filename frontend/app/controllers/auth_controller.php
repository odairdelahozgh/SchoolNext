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
      try {
        $this->page_title = 'Login';
        View::template(template: 'login');
        if((new User)->login()) { Redirect::to(route: 'index'); }
        OdaLog::debug("2) FIN");

      } catch (\Throwable $th) {
        OdaFlash::error($th);
      }
    } //END-

    public function logout(): void {
      try {
        (new User)->logout();
        Redirect::toAction(action: 'login');
        OdaLog::debug("3) FIN");

      } catch (\Throwable $th) {
        OdaFlash::error($th);
      }
    } //END-

}

