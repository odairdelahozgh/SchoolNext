SELECT e.id, e.grado_mat, g.nombre as grado, CONCAT(e.apellido1, ' ', e.apellido2, ' ', e.nombres) as estudiante, 
e.email, CONCAT(e.email_instit,'@windsorschool.edu.co') AS email_windsor
FROM sweb_estudiantes as e
LEFT JOIN sweb_grados     AS g ON e.grado_mat  = g.id

WHERE e.is_active=1
ORDER BY g.orden DESC, e.apellido1, e.apellido2, e.nombres