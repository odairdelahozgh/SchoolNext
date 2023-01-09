`cons_prom_general_2021_5periodo` AS 
select `N`.`annio` AS `annio`,`N`.`periodo_id` AS `periodo_id`,`S`.`nombre` AS `salon`,
concat(trim(`E`.`nombres`),' ',`E`.`apellido1`,' ',`E`.`apellido2`) AS `estudiante`,
round(avg(if((`N`.`nota_final` > 0),`N`.`nota_final`,if((`N`.`plan_apoyo` > 0),`N`.`plan_apoyo`,`N`.`definitiva`))),2) AS `promedio` 

from (((`sweb_notas_2021` `N` 
left join `sweb_estudiantes` `E` on((`N`.`estudiante_id` = `E`.`id`))) 
left join `sweb_asignaturas` `A` on((`N`.`asignatura_id` = `A`.`id`))) 
left join `sweb_salones` `S` on((`N`.`salon_id` = `S`.`id`))) 
where ((`N`.`periodo_id` = 5) and (`N`.`grado_id` <= 11)) 
group by `N`.`annio`,`N`.`periodo_id`,`N`.`salon_id`,`N`.`estudiante_id` 
order by `N`.`salon_id`,`promedio` desc