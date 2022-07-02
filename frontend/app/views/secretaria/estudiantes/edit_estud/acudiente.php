<?php
echo _Tag('p.t_medium_azul', "Datos del Acudiente");
$msg_ayuda = 'Diligencie los datos del Acudiente, sólo si es diferente a padre o madre.';
$tabla = _open('table', array('width'=>'100%'))
 ._Tag('tr', $form->getColCampo('Datosestud/tipo_acudi') .'<td colspan="2">'.$msg_ayuda.'<td>' )
 ._Tag('tr', $form->getColCampo('Datosestud/acudiente,Datosestud/parentesco'))
 ._Tag('tr', $form->getColCampo('Datosestud/acudi_id,Datosestud/acudi_dir'))
 ._Tag('tr', $form->getColCampo('Datosestud/acudi_tel_1,Datosestud/acudi_email'))
 ._Tag('tr', $form->getColCampo('Datosestud/acudi_lugar_tra,Datosestud/acudi_ocupa'))
 ._Tag('tr', $form->getColCampo('Datosestud/acudi_tel_2'))
 ._close('table');
echo $tabla;