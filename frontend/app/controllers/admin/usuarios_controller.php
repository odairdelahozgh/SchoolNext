<?php

class UsuariosController extends AppController
{
    public string $model = 'usuario';
    
    public function index($page = 1) {
      $this->arrColumnas = ['Activo?', 'ID', 'username', 'Documento', 'Nombre'];
      $this->data = (new $this->model)->all();
    }

    public function ver($id) {
        $this->data = (new Usuario)->get((int) $id);
    }

    /**
     * Edita un Registro
     * @param int $id  Idendificador del registro
     */
    public function editar($id) {
        View::select('crear');
        if (Input::hasPost($this->model)) {
            $obj = new $this->model;
            if (!$obj->update(Input::post($this->model))) {
                Flash::error('Falló Operación');
                $this->{$this->model} = Input::post($this->model);
            } else {
                Redirect::to();
                return;
            }
        }
        $this->{$this->model} = (new $this->model)->get((int) $id);
    }

    
    /**
     * Crea un Registro
     */
    public function crear() {
        if (Input::hasPost($this->model)) {
            $obj = new $this->model;
            if (!$obj->save(Input::post($this->model))) {
                Flash::error('Falló Operación');
                $this->{$this->model} = $obj;
                return;
            }
            Redirect::to();
            return;
        }
        $this->{$this->model} = new $this->model;
    }


    /**
     * Borra un Registro
     * 
     * @param int $id Identificador de registro
     */
    public function borrar($id) {
        if (!(new $this->model)->delete((int) $id)) {
            Flash::error('Falló Operación');
        }
        //enrutando al index para listar los articulos
        Redirect::to();
    }

}