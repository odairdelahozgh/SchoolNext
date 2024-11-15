<?php
/**
 * KumbiaPHP Web Framework
 * Parámetros de configuracion de la aplicacion
 *  @example (int)Config::get(var: 'academic.periodo_actual');
 */

$year = date('Y');

return [
    'windsor' => [
      'nombre'  => 'Windsor School',
      'razon_social'  => 'Windsor Group SAS',
      'id_name' => 'windsor',
      'nit' => '900329420',
      'cod_dane'  => '320001068151',
      'resolucion'  => '293, Nov 4 de 2011',

      'slogan'  => 'Brilliant minds for a challenging world',
      'campania'  => 'No esperemos que el mundo cambie. Primero hagámoslo nosotros.',
      'logo'            => 'logo_windsor.png',
      'logo_resolucion' => 'logo_brand_windsor.png',
      
      'ciudad' => 'Valledupar',
      'direccion' => 'Kilometro 2.5 via Rio Seco - Valledupar, Cesar',
      'telefono_fijo' => '(+601) 794-4484',
      'telefono_movil'  => '(+57) 317 370 4197',
      'email' => 'windsorschoolvalledupar@gmail.com',
      'dominio' => 'windsorschool.edu.co',
      'website' => 'https://www.windsorschool.edu.co',
      
      'rector'          => 'Miriam Casadiego Ríos',
      'rector_cc'       => '57401865',
      
      'rep_legal'       => 'Yani Calderón Sarmiento',
      'rep_legal_cc'    => '',
      
      'secretaria'      => 'Yuleinis Manjarres Gil',
      'secretaria_cc'   => '1065579951',
      
      'contador'        => 'Mary Monachello',
      'contador_cc'     => '',
    ],

    'santarosa' => [
      'nombre'       => 'Colegio Mixto Santa Rosa',
      'razon_social' => 'Colegio Mixto Santa Rosa',
      'id_name'      => 'santarosa',
      'nit'          => '',
      'cod_dane'     => '',
      'resolucion'   => '',

      'slogan'          => '',
      'campania'        => '',
      'logo'            => 'logo_santarosa.png',
      'logo_resolucion' => 'logo_brand_santarosa.png',
      
      'ciudad' => 'Valledupar',
      'direccion' => '',
      'telefono_fijo' => '(+601)',
      'telefono_movil'  => '(+57)',
      'email' => '',
      'dominio' => 'colegiomixtosantarosa.com',
      'website' => 'https://www.colegiomixtosantarosa.com',
      
      'rector'          => 'Luz Aida Remicio',
      'rector_cc'       => '',
      
      'rep_legal'       => 'Luz Aida Remicio',
      'rep_legal_cc'    => '',
      
      'secretaria'      => 'Jahni Delgado',
      'secretaria_cc'   => '',
      
      'contador'        => '',
      'contador_cc'     => '',
    ],
];
