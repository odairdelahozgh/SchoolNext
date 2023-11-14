
/*AÑO ACTUAL*/
SELECT 
N.annio, 
N.periodo_id, 
N.grado_id, G.nombre AS grado,
N.asignatura_id, A.abrev AS asignatura,
N.estudiante_id, CONCAT (E.apellido1, " ", E.apellido2, " ", E.nombres) AS estudiante,
N.definitiva, N.plan_apoyo, N.nota_final

FROM sweb_notas AS N 
LEFT JOIN sweb_estudiantes AS E ON N.estudiante_id = E.id
LEFT JOIN sweb_asignaturas AS A ON N.asignatura_id = A.id
LEFT JOIN sweb_grados      AS G ON N.grado_id = G.id

WHERE 
N.periodo_id in (1,2,3,4) AND
N.estudiante_id IN(SELECT EG.id FROM sweb_estudiantes AS EG WHERE EG.is_active=1 AND EG.grado_mat=11)




UNION ALL

SELECT 
N.annio, 
N.periodo_id, 
N.grado_id, G.nombre AS grado,
N.asignatura_id, A.abrev AS asignatura,
N.estudiante_id, CONCAT (E.apellido1, " ", E.apellido2, " ", E.nombres) AS estudiante,
N.definitiva, N.plan_apoyo, 
IF(N.nota_final>0, N.nota_final,
  IF(N.plan_apoyo>0, N.plan_apoyo,
    IF(N.definitiva>0, N.definitiva,
      0
    )
  )
) AS nota_final

FROM sweb_notas_2022 AS N 
LEFT JOIN sweb_estudiantes AS E ON N.estudiante_id = E.id
LEFT JOIN sweb_asignaturas AS A ON N.asignatura_id = A.id
LEFT JOIN sweb_grados      AS G ON N.grado_id = G.id

WHERE N.periodo_id=5 AND N.estudiante_id IN(SELECT EG.id FROM sweb_estudiantes AS EG WHERE EG.is_active=1 AND EG.grado_mat=11)


UNION ALL

SELECT 
N.annio, 
N.periodo_id, 
N.grado_id, G.nombre AS grado,
N.asignatura_id, A.abrev AS asignatura,
N.estudiante_id, CONCAT (E.apellido1, " ", E.apellido2, " ", E.nombres) AS estudiante,
N.definitiva, N.plan_apoyo, 
IF(N.nota_final>0, N.nota_final,
  IF(N.plan_apoyo>0, N.plan_apoyo,
    IF(N.definitiva>0, N.definitiva,
      0
    )
  )
) AS nota_final

FROM sweb_notas_2021 AS N 
LEFT JOIN sweb_estudiantes AS E ON N.estudiante_id = E.id
LEFT JOIN sweb_asignaturas AS A ON N.asignatura_id = A.id
LEFT JOIN sweb_grados      AS G ON N.grado_id = G.id

WHERE N.periodo_id=5 AND N.estudiante_id IN(SELECT EG.id FROM sweb_estudiantes AS EG WHERE EG.is_active=1 AND EG.grado_mat=11)

UNION ALL

SELECT 
N.annio, 
N.periodo_id, 
N.grado_id, G.nombre AS grado,
N.asignatura_id, A.abrev AS asignatura,
N.estudiante_id, CONCAT (E.apellido1, " ", E.apellido2, " ", E.nombres) AS estudiante,
N.definitiva, N.plan_apoyo, 
IF(N.nota_final>0, N.nota_final,
  IF(N.plan_apoyo>0, N.plan_apoyo,
    IF(N.definitiva>0, N.definitiva,
      0
    )
  )
) AS nota_final

FROM sweb_notas_2020 AS N 
LEFT JOIN sweb_estudiantes AS E ON N.estudiante_id = E.id
LEFT JOIN sweb_asignaturas AS A ON N.asignatura_id = A.id
LEFT JOIN sweb_grados      AS G ON N.grado_id = G.id

WHERE N.periodo_id=5 AND N.estudiante_id IN(SELECT EG.id FROM sweb_estudiantes AS EG WHERE EG.is_active=1 AND EG.grado_mat=11)


UNION ALL

SELECT 
N.annio, 
N.periodo_id, 
N.grado_id, G.nombre AS grado,
N.asignatura_id, A.abrev AS asignatura,
N.estudiante_id, CONCAT (E.apellido1, " ", E.apellido2, " ", E.nombres) AS estudiante,
N.definitiva, N.plan_apoyo, 
IF(N.nota_final>0, N.nota_final,
  IF(N.plan_apoyo>0, N.plan_apoyo,
    IF(N.definitiva>0, N.definitiva,
      0
    )
  )
) AS nota_final

FROM sweb_notas_2019 AS N 
LEFT JOIN sweb_estudiantes AS E ON N.estudiante_id = E.id
LEFT JOIN sweb_asignaturas AS A ON N.asignatura_id = A.id
LEFT JOIN sweb_grados      AS G ON N.grado_id = G.id

WHERE N.periodo_id=5 AND N.estudiante_id IN(SELECT EG.id FROM sweb_estudiantes AS EG WHERE EG.is_active=1 AND EG.grado_mat=11)

UNION ALL

SELECT 
N.annio, 
N.periodo_id, 
N.grado_id, G.nombre AS grado,
N.asignatura_id, A.abrev AS asignatura,
N.estudiante_id, CONCAT (E.apellido1, " ", E.apellido2, " ", E.nombres) AS estudiante,
N.definitiva, N.plan_apoyo, 
IF(N.nota_final>0, N.nota_final,
  IF(N.plan_apoyo>0, N.plan_apoyo,
    IF(N.definitiva>0, N.definitiva,
      0
    )
  )
) AS nota_final

FROM sweb_notas_2018 AS N 
LEFT JOIN sweb_estudiantes AS E ON N.estudiante_id = E.id
LEFT JOIN sweb_asignaturas AS A ON N.asignatura_id = A.id
LEFT JOIN sweb_grados      AS G ON N.grado_id = G.id

WHERE N.periodo_id=5 AND N.estudiante_id IN(SELECT EG.id FROM sweb_estudiantes AS EG WHERE EG.is_active=1 AND EG.grado_mat=11)

