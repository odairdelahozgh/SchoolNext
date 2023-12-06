<?php
$year = date('Y');
$month = date('m');

return [
  'mostrar_matriculas'   => 0,
  'matriculas_fecha_ini' => '',
  'mostrar_fecha_fin'    => '',
  'annio_mat'     => (($month>=11) ? $year : $year+1),
];
