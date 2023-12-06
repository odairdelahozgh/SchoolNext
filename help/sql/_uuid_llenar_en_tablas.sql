update sweb_notas 
set uuid = (select md5(UUID()))
WHERE LENGHT(uuid)=0;