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
        $this->breadcrumb->addCrumb(title:'Grados');
        $this->data = (new Grado)->getListSeccion();
        $this->tot_regs = count($this->data);
    }
    
    
	private function reglas() {
	
		return array(
            'grados.abrev' => [
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
        $this->page_action = 'CREAR Registro';
        $Grado = new Grado(true);
        $this->secciones = (new Seccion)->getListActivos('id, nombre');
        $this->salones   = (new Salon)->getListActivos('id, nombre');
        $this->grados    = (new Grado)->getListActivos('id, nombre');

        if (Input::hasPost('grados')) {
/*             $validador = new Validate(Input::post('grados.nombre'), $this->reglas() );
            if (!$validador->exec()) {
                $validador->flash();
                //OdaFlash::error('Falló Operación VALIDAR :: Crear Registro');
                return false;
            } */
            if ( $Grado->create(Input::post('grados'))) {
                OdaFlash::valid('Operación exitosa :: Crear Registro');
                Input::delete();
                return Redirect::to(); // al index del controller
            }
            OdaFlash::error('Falló Operación :: Crear Registro');
        }
    }
   
  /**
     * Edita un Registro
     *
     * @param int $id (requerido)
     */
    public function edit($id=0) {
        $this->page_action = 'EDITAR un Registro';
        $Grado = new Grado();
        $this->secciones = (new Seccion)->getListActivos('id, nombre');
        $this->salones   = (new Salon)->getListActivos('id, nombre');
        $this->grados    = (new Grado)->getListActivos('id, nombre');
        
        if (Input::hasPost('grados')) {
            if ($Grado->update(Input::post('grados'))) {
                OdaFlash::valid('Operación exitosa: Se guardó el registro');
                return Redirect::to(); // al index del controller
            }
            OdaFlash::error('Falló Operación: Editar Registro');
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
        if ((new Grado)->deleteUUID($uuid)) {
            OdaFlash::valid('Operación exitosa: Se eliminó el registro');
        } else {
            OdaFlash::error('Falló Operación: eliminar registro');
        }
        return Redirect::to();
    }

} // END CLASS
