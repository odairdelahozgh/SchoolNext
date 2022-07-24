<?php
/**
 * KumbiaPHP Web Framework
 * Archivo de rutas (Opcional)
 * 
 * Usa este archivo para definir el enrutamiento estatico entre
 * controladores y sus acciones.Un controlador se puede enrutar a 
 * otro controlador utilizando '*' como comodin así:
 * 
 * '/controlador1/accion1/valor_id1'  =>  'controlador2/accion2/valor_id2'
 * 
 * Ej:
 * Enrutar cualquier petición a posts/adicionar a posts/insertar/*
 * '/posts/adicionar/*' => 'posts/insertar/*'
 * 
 * Otros ejemplos:
 * 
 * '/prueba/ruta1/*' => 'prueba/ruta2/*',
 * '/prueba/ruta2/*' => 'prueba/ruta3/*',
 */
return [
    'routes' => [
        '/' => 'auth/login',
        '/logout'  => 'auth/logout',
        '/ayuda'   => 'pages/ayuda',
        '/colores' => 'pages/colores',
        '/iconos'  => 'pages/iconos',

        '/docen-carga-academica' => 'docentes/carga',
        '/carga'                 => 'docentes/carga',
        
        '/docen-registros-gen'   => 'docentes/registros_gen',
        '/registros-gen'         => 'docentes/registros_gen',

        '/docen-dir-grupo'       => 'docentes/direccion_grupo',
        '/dirreccion-grupo'      => 'docentes/direccion_grupo',
        
        '/docen-notas'           => 'docentes/notas',
        '/notas'                 => 'docentes/notas',
        
        '/docen-indicadores'     => 'docentes/indicadores',
        '/indicadores'           => 'docentes/indicadores',
        
        '/coord-consoli-notas'   => 'coordinador/consolidado_notas',
        '/coord-registros'       => 'coordinador/gestion_registros',
        
        '/secre-estud-list-activos'   => 'secretaria/listadoEstudActivos',
        '/secre-estud-edit-activos'   => 'secretaria/editarEstudActivos',
        '/secre-estud-list-inactivos' => 'secretaria/listadoEstudInactivos',
        ],
];
