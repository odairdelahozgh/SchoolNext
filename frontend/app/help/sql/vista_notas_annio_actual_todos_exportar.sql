select 
N.annio AS annio,
N.periodo_id AS periodo_id,
N.grado_id AS grado_id,
N.salon_id AS salon_id,
N.asignatura_id AS asignatura_id,
N.estudiante_id AS estudiante_id,
concat(E.nombres,' ',E.apellido1,' ',E.apellido2, ' [', S.abrev, ']') AS estudiante,
G.nombre AS grado,
S.nombre AS salon,
A.nombre AS asignatura,
A.abrev AS asignatura_abrev,
N.definitiva AS definitiva,
N.plan_apoyo AS plan_apoyo,
N.nota_final AS nota_final,
IF(N.nota_final<0, "Error: Nota Final [<0]", 
  IF(N.nota_final=0, "NO Calificado [=0]", 
    IF(N.nota_final<60, "Bajo", 
      IF(N.nota_final<70, "Basico", 
        IF(N.nota_final<80, "Basico +", 
          IF(N.nota_final<90, "Alto", 
            IF(N.nota_final<95, "Alto +", 
              IF(N.nota_final<=100, "Superior", 
                "Error: Nota Final [>100]")
            )
          )
        )
      )
    )
  )
)
AS desempeno

from 
((( (sweb_notas N left join sweb_asignaturas A on (N.asignatura_id = A.id)) 
      left join sweb_estudiantes E on(N.estudiante_id = E.id) ) 
        left join sweb_salones S on(N.salon_id = S.id) ) 
          left join sweb_grados G on(N.grado_id = G.id) )

WHERE (N.periodo_id = 5) and (N.asignatura_id <> 30) and (N.grado_id<=11) 

ORDER BY 
S.position,E.nombres,E.apellido1,E.apellido2,N.periodo_id,A.abrev
