SELECT 
H.annio,
H.periodo_id,
H.salon_id,
S.nombre AS salon,
count(0) AS total_registros 
FROM (sweb_notas_historia H LEFT JOIN sweb_salones S ON ((H.salon_id = S.id))) 
GROUP BY H.annio,H.periodo_id,H.salon_id 
ORDER BY H.annio,H.periodo_id,S.position