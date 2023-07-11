<?php

/**
 * Controller por defecto si no se usa el routes
 *
 */
class AuthController extends AdminController
{
  public function index(): void {
    Redirect::toAction(action: 'login');
  }

  public function login(): void {
    try {
    View::template(template: 'login');
    if((new User)->login()) { 
      Redirect::to(route: 'index'); 
    }

    } catch (\Throwable $th) {
    OdaFlash::error($th);
    }
  } //END-login

  public function logout(): void {
    try {
    (new User)->logout();
    Redirect::toAction(action: 'login');

    } catch (\Throwable $th) {
    OdaFlash::error($th);
    }
  } //END-logout

} //END-CLASS