SELECT e.id, e.grado_mat, g.nombre as grado, e.numero_mat, CONCAT(e.apellido1, ' ', e.apellido2, ' ', e.nombres) as estudiante, 
p.madre, CONCAT(madre_tel_1, ' ', madre_tel_2) as tels_madre, 
p.padre, CONCAT(padre_tel_1, ' ', padre_tel_2) as tels_padre
FROM sweb_estudiantes as e
LEFT JOIN sweb_datosestud AS p ON e.id = p.estudiante_id 
LEFT JOIN sweb_grados     AS g ON e.grado_mat  = g.id

WHERE e.is_active=1
ORDER BY g.orden DESC, e.apellido1, e.apellido2, e.nombres