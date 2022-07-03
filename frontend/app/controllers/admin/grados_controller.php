<?php
/**
  * Controlador Grados  
  * @category App
  * @package Controllers https://github.com/KumbiaPHP/Documentation/blob/master/es/controller.md
  */
  
class GradosController extends AppController
{

    public function index() {
        Redirect::toAction('list');
    }

    public function list() {
        $this->page_action = 'Lista de Grados';
        $this->breadcrumb  = $this->bc('Grados');
        $this->data = (new Grado)->getList();
        $this->tot_regs = count($this->data);
    }
    
    
	private function reglas() {
	
		return array(
            'grados.nombre' => [
                'required' => ['error' => 'El nombre es obligatorio.'],
            ],
            /*
			'NombreCompleto' => [
				'required' => ['error' => 'Indique su nombre.'],
				'alpha'    => ['error' => 'Nombre incompleto o incorrecto.']
			],
			'Email' => [
				'required' => ['error' => 'Indique su email.'],
				'email'    => ['error' => 'Email incorrecto.']
			],
			'Movil' => [
				'required' => ['error' => 'Indique su teléfono / móvil.'],
				'length'   => ['min' => '9',
                                'max' => '17',
                                'error' => 'Teléfono / móvil incorrecto'],
				'pattern'  => ['regexp' => '/^\+(?:[0-9] ?){6,14}[0-9]$/', 
                                'error'  => 'Teléfono incorrecto. Formato ejemplo. +34 862929929']
			],
			'Asunto' => [
				'required' => ['error' => 'Indique un asunto.'],
			],
			/'Mensaje' => [
				'required' => ['error' => 'Indique un mensaje.'],
				'length'   => ['min' => 100,
                                'error' => 'Si es posible, concrete más en su mensaje.'],
			]
            */
		);

	}


    public function enviar($datos) {
        $validador = new Validate($datos, $this->reglas() );
        if (!$validador->exec()) {
                $validador->flash();
                return false;
        }
        // proseguir con el proceso
    }
    /*$validador = new Validate(Input::post('grados.nombre'), $this->reglas() );
    if (!$validador->exec()) {
        $validador->flash();
        return false;
    }*/

    /**
     * Crea un Registro
     */
    public function create() {
        $Grado = new Grado(true);
        if (Input::hasPost('grados')) {
            if ( $Grado->create(Input::post('grados'))) {
                Flash::valid('Operación exitosa :: Crear Registro Grado');
                Input::delete();
                return Redirect::to(); // al index del controller
            }
            Flash::error('Falló Operación :: Crear Registro Grado');
        }
    }
   
  /**
     * Edita un Registro
     *
     * @param int $id (requerido)
     */
    public function edit($id=0) {
        $Grado = new Grado();
        if (Input::hasPost('grados')) {
            if ($Grado->update(Input::post('grados'))) {
                //Flash::valid('Operación exitosa');
                return Redirect::to(); // al index del controller
            }
            Flash::error('Falló Operación');
            return; // Redirect::to('?');
        }
        $this->Modelo = $Grado->get((int) $id);
    }

    /**
     * Eliminar un registro
     *
     * @param int $id (requerido)
     */
    public function del($uuid) {
        if ((new Grado)->deleteUuid($uuid)) {
            Flash::valid('Operación exitosa: grado id=$id eliminado');
        } else {
            Flash::error('Falló Operación');
        }
        return Redirect::to();
    }

} // END CLASS
