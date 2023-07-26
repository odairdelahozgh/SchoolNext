document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('btn-0').click();
});

function traer_data(salon_id) {
  console.clear();
  let ruta_base = document.getElementById('public_path').innerHTML.trim();
  let theme = document.getElementById('theme').innerHTML.trim();
  
  fetch(ruta_base+'api/notas/notas_salon/'+salon_id)
  .then((res) => res.json())
  .then(datos => {
    let periodo_actual = document.getElementById('periodo').innerHTML.trim();
    let body_table = '';
    let caption = '';

    for (let salon in datos) { 
      [salon_nombre, salon_id, salon_uuid] = salon.split(";");
      lnk_boletines_salon = 'Boletines:&nbsp;&nbsp;';
      for (let index=1; index<=periodo_actual; index++) {
        lnk_boletines_salon +=  `
        <a href="${ruta_base}admin/notas/exportBoletinSalonPdf/${index}/${salon_uuid}" 
        class="w3-btn w3-round-large w3-black" 
        target="_blank" 
        title="Descarga Boletines de ${salon_nombre} (Per&iacute;odo ${index})">
        <i class="fa-solid fa-file-pdf"></i> ${salon_nombre} (P${index})</a> &nbsp;
        `;
      }

      caption = `<h2>Salon:${salon_nombre}</h2> ${lnk_boletines_salon}<br><br>`;

      for (let estudiante in datos[salon]) {
        [estudiante_nombre, estudiante_id, estudiante_uuid]= estudiante.split(";");
        body_table += '<tr class="w3-theme-'+theme.toString().substr(0,1)+'5"><td colspan=10>'+estudiante_nombre+'</td></tr>';
        cont = 1;
        for (let periodo in datos[salon][estudiante]) { // fila de titulos de materia
          if (cont==1) {
            body_table += '<tr class="w3-theme-d3"><td>Per&iacute;odo</td>'; 
            for (let asignatura in datos[salon][estudiante][periodo]) {
              [asignatura_nombre, asignatura_abrev]= asignatura.split(";");
              body_table += '<td>' + asignatura_abrev + '</td>';
            }
            body_table += '</tr>';
            cont += 1;
          }

          lnk_boletin_estud_periodo =  `
            <a href="${ruta_base}admin/notas/exportBoletinEstudiantePdf/${periodo}/${estudiante_uuid}" 
            class="w3-btn w3-round-large w3-black w3-tiny" 
            target="_blank"
            title="Descarga Boletin de ${estudiante_nombre} (Per&iacute;odo ${periodo})">
            <i class="fa-solid fa-file-pdf"></i>&nbsp;B P${periodo}</a>
          `;
          body_table += '<tr class="w3-theme-l3"><td>'+lnk_boletin_estud_periodo+'</td>'; 

          for (let asignatura in datos[salon][estudiante][periodo]) {
            nota = datos[salon][estudiante][periodo][asignatura];
            [reg_id, reg_uuid, definitiva, plan_apoyo, nota_final, desempeno, is_asi_validar_ok, is_paf_validar_ok] = datos[salon][estudiante][periodo][asignatura].split(";");
                        
            asi = (is_asi_validar_ok==1) ? '<span class="w3-border w3-green w3-tiny">S.I.</span>' : '';
            paf = (is_paf_validar_ok==1) ? '<a href="'+ruta_base+'admin/planes_apoyo/exportPlanesApoyoRegistroPdf/'+reg_uuid+'" class="w3-border w3-orange w3-tiny" target="_blank" title="Plan de Apoyo">P.A.</a>' : '';
            br = ((asi.length+paf.length)>0) ? '<br>' : '';
            let lleva_pa = '';
            if (definitiva<60) {
              lleva_pa = (plan_apoyo > 0) ? 'PA:'+plan_apoyo+'<br>' : 'PA:?<br>';
            }
            body_table += `<td class="w3-center">${lleva_pa} <strong>${nota_final}</strong> ${br} ${asi} ${paf}</td>`;
          }
          body_table += '</tr>';
        }
      }
    }
        
    document.querySelector('#resultados').innerHTML = `
      <table id="myTable"class="w3-table w3-responsive w3-bordered w3-small">
        <caption id="tcaption" class="w3-left-align w3-bottombar w3-border-blue">${caption}</caption>
        <tbody id="tbody">${body_table}</tbody>
      </table>
      `;
    })
    .catch(
        error => console.log(error)
    );


}