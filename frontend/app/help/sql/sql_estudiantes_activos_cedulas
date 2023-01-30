SELECT 
g.nombre AS grado, 
e.numero_mat, 
e.documento, 
e.apellido1, 
e.apellido2, 
e.nombres 

FROM sweb_estudiantes AS e 
LEFT JOIN sweb_grados AS g ON e.grado_mat = g.id 
WHERE e.is_active =1 
ORDER BY e.grado_mat, e.apellido1, e.apellido2, e.nombres
