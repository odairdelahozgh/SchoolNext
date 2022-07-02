<?php
/*
echo _Tag'p.t_medium_azul', "Archivos Adjuntos a la Matrícula");

$html_params = array();
$html_params_oculto = array('hidden'=>'hidden');

echo $form->getCampo('Adjuntos/estudiante_id', $html_params_oculto);
echo $form->getCampo('AdjuntosDos/estudiante_id', $html_params_oculto);

echo $form->getColCampo('is_habilitar_mat');

$arch = _open('table');
for ($i=1; $i<=5; $i++) {
	$link_descarga = $form->getObject()->getAdjuntos()->getLinkAchivoAdjunto($i).'<br/>';
	$campo_archivo = $form->getCampo('Adjuntos/nombre_archivo'.$i).'<br/>';
	$campo_estado = $form->getCampo('Adjuntos/estado_archivo'.$i).'<br/>';
	$campo_coment = $form->getCampo('Adjuntos/coment_archivo'.$i).'<br/>';
	$arch .= _Tag'tr', _Tag'td', $campo_estado.'Comentarios: '.$campo_coment) 
				._Tag'td', $link_descarga .$campo_archivo)
			);
}

for ($i=1; $i<=2; $i++) {
	$link_descarga = $form->getObject()->getAdjuntosDos()->getLinkAchivoAdjunto($i).'<br/>';
	$campo_archivo = $form->getCampo('AdjuntosDos/nombre_archivo'.$i).'<br/>';
	$campo_estado = $form->getCampo('AdjuntosDos/estado_archivo'.$i).'<br/>';
	$campo_coment = $form->getCampo('AdjuntosDos/coment_archivo'.$i).'<br/>';
	$arch .= _Tag'tr', _Tag'td', $campo_estado.'Comentarios: '.$campo_coment) 
				._Tag'td', $link_descarga .$campo_archivo)
			);
}


$arch .= _close('table');

echo $arch;
*/