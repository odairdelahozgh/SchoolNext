SELECT * FROM sweb_notas as notas 
WHERE notas.periodo_id = 3 and notas.salon_id = 25 and notas.estudiante_id in 
( select DISTINCT n.estudiante_id from sweb_notas as n 
where n.periodo_id = 3 AND n.salon_id = 25 
group by n.periodo_id, n.estudiante_id, n.asignatura_id 
HAVING count(n.estudiante_id)>1 ) 
order BY notas.estudiante_id, notas.asignatura_id;