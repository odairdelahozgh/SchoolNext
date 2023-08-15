<?php

/**
 * Controller por defecto si no se usa el routes
 *
 */
class AuthController extends AdminController
{
  public function index(): void {
    Redirect::toAction('login');
  }

  public function login(): void {
    try {
      View::template('login');
      if((new User)->login()) { 
        Redirect::to('index'); 
      }
      
    } catch (\Throwable $th) {
    OdaFlash::error($th);
    }
  } //END-login

  public function logout(): void {
    try {
    (new User)->logout();
    Redirect::toAction('login');

    } catch (\Throwable $th) {
    OdaFlash::error($th);
    }
  } //END-logout

} //END-CLASS