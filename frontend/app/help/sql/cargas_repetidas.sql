SELECT SAP.salon_id, S.nombre AS salon, SAP.asignatura_id, A.nombre AS asignatura, count(*) as total 
FROM sweb_salon_asignat_profesor AS SAP 
LEFT JOIN sweb_salones AS S ON SAP.salon_id = S.id 
LEFT JOIN sweb_asignaturas AS A ON SAP.asignatura_id = A.id 
GROUP BY salon_id, asignatura_id 
HAVING total > 1 ORDER BY total DESC


