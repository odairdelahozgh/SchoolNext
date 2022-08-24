SELECT 
N.annio, 
N.periodo_id, 
S.nombre AS salon, 
CONCAT(TRIM(E.nombres), ' ', E.apellido1, ' ', E.apellido2) as estudiante, 
round(avg(IF(N.nota_final>0, N.nota_final, IF(N.plan_apoyo>0, N.plan_apoyo, N.definitiva))),2) as promedio
FROM sweb_notas_2021 AS N 
LEFT JOIN sweb_estudiantes AS E ON N.estudiante_id = E.id
LEFT JOIN sweb_asignaturas AS A ON N.asignatura_id = A.id
LEFT JOIN sweb_salones     AS S ON N.salon_id = S.id

WHERE N.periodo_id =5 AND N.grado_id <= 11

GROUP BY N.annio, N.periodo_id, N.salon_id, N.estudiante_id
ORDER BY N.salon_id, promedio DESC

/*
cons_prom_general_2021_5periodo

$sql = "SELECT N.annio, N.periodo_id, S.nombre AS salon, CONCAT(TRIM(E.nombres), \' \', E.apellido1, \' \', E.apellido2) as estudiante, avg(N.nota_final) as promedio\n"
    . "FROM sweb_notas_2021 AS N \n"
    . "LEFT JOIN sweb_estudiantes AS E ON N.estudiante_id = E.id\n"
    . "LEFT JOIN sweb_asignaturas AS A ON N.asignatura_id = A.id\n"
    . "LEFT JOIN sweb_salones     AS S ON N.salon_id = S.id\n"
    . "WHERE N.periodo_id =5\n"
    . "GROUP BY N.annio, N.periodo_id, N.salon_id, N.estudiante_id\n"
    . "ORDER BY N.salon_id, promedio DESC";
*/