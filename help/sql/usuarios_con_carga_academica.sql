SELECT 
u.id, 
u.username, 
CONCAT(u.nombres, " ", u.apellido1, " ", u.apellido2) as docente, 
u.documento, 
IF (LENGTH(u.usuario_instit)>0, CONCAT(u.usuario_instit, "@windsorschool.edu.co"), '') AS usuario_teams, 
IF (LENGTH(u.clave_instit)>0, u.clave_instit, '') AS clave_teams,
count(sap.user_id) as carga

FROM dm_user as u 
LEFT JOIN sweb_salon_asignat_profesor as sap ON u.id = sap.user_id 

WHERE u.is_active=1 
GROUP BY u.id 
HAVING count(sap.user_id)>0