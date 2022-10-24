<?php

class UsuariosController extends AppController
{
    public string $model = 'usuario';
    
    /**
     * Index Page
     * @param int $page paginacion
     */
    public function index($page = 1) {
      $this->arrColumnas = ['Activo?', 'ID', 'username', 'Documento', 'Nombre'];
      $this->data = (new $this->model)->all();
    }

    /**
     * Página ver Registro
     * @param int $id Llave principal del registro
     */
    public function ver($id) {
        $this->display = [
            'Usuario'       => ['username', 'is_active', 'password', 'password_again', 'is_super_admin', 'is_partner'],
            'Datos Básicos' => ['nombres', 'apellido1', 'apellido2', 'documento', 'fecha_nac', 'sexo'],
            'Laboral'       => ['profesion', 'cargo', 'fecha_ing', 'fecha_ret', 'is_carga_acad_ok'],
            'Ubicacion'     => ['direccion', 'telefono1', 'telefono2', 'email' ],
            'Otros'         => ['observacion'],
            /*
            "Groups & Permissions" => ['groups_list', 'permissions_list']
            "Asignaturas que Dicta": [user_asignaturas_dicta_list],
            "Secciones donde Dicta Clases":   [user_secciones_dicta_list],
            #Relaciones:       [dm_user_estudiante_list],
            */
        ];
        $this->data = (new Usuario)->get((int) $id);
    }

    /**
     * Edita un Registro
     * @param int $id Idendificador del registro
     */
    public function editar($id) {
        View::select('editar');
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
        View::select('crear');
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