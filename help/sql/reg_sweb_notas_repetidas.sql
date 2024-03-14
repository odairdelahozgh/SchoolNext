SELECT COUNT(id), annio, periodo_id, grado_id, salon_id, asignatura_id, estudiante_id
FROM sweb_notas 
GROUP BY annio, periodo_id, grado_id, salon_id, asignatura_id, estudiante_id
HAVING COUNT(id)> 1  
ORDER BY annio, periodo_id, grado_id, salon_id, asignatura_id, estudiante_id ASC;


SELECT * FROM sweb_notas as notas 
WHERE notas.periodo_id = 3 and notas.salon_id = 19 and notas.estudiante_id in 
( select DISTINCT n.estudiante_id from sweb_notas as n 
where n.periodo_id = 3 AND n.salon_id = 19
group by n.periodo_id, n.estudiante_id, n.asignatura_id 
HAVING count(n.estudiante_id)>1 ) 
order BY notas.estudiante_id, notas.asignatura_id;