<?php
trait EstudianteTraitDatosPadres {

  
  public function getInfoContactoPadres(bool $log=false): array|string {

    $DQL = (new OdaDql(_from: __CLASS__))
        ->select(select: 't.id as estudiante_id, CONCAT(t.apellido1, " ", t.apellido2, " ", t.nombres) as estudiante_nombre')
        ->addSelect(select: 's.id as salon_id, s.nombre AS salon_nombre, s.grado_id as grado_id, g.nombre as grado_nombre')
        ->addSelect(select: 'de.madre as madre_nombre, de.madre_tel_1 as madre_telefono_1, de.madre_tel_2 as madre_telefono_2, de.madre_email as madre_email')
        ->addSelect(select: 'de.padre as padre_nombre, de.padre_tel_1 as padre_telefono_1, de.padre_tel_2 as padre_telefono_2, de.padre_email as padre_email')
        ->addSelect(select: 'de.tipo_acudi as acudiente')
        ->leftJoin(table_singular: 'datosestud', alias: 'de', condition: 't.id=de.estudiante_id')
        ->leftJoin(table_singular: 'salon', alias: 's')
        ->leftJoin(table_singular: 'grado', alias: 'g', condition: 's.grado_id=g.id')
        ->orderBy(sort: 'g.orden,s.nombre,t.apellido1,t.apellido2, t.nombres')
        ->where(where: 't.is_active=1 and s.is_active=1');
    return $DQL->execute(write_log: $log);
  } // END-getListEstudiantes

} //END-EstudianteTraitDatosPadres