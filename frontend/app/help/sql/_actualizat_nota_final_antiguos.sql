update sweb_notas_2011 set nota_final = IF(nota_final=0 and plan_apoyo=0, definitiva, nota_final)

update sweb_notas_2011 set nota_final = IF(nota_final=0, IF(definitiva>plan_apoyo, definitiva, plan_apoyo), nota_final)