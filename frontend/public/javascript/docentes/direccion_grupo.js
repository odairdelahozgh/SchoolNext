
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('btn-1').click();
});


function traer_data(salon_id) {
let ruta = document.getElementById('public_path').innerHTML.trim();
let theme = document.getElementById('theme').toString().substr(0, 1);

fetch(ruta+'api/notas/notas_salon/'+salon_id)
.then((res) => res.json())
.then(datos => {
  console.clear();
  console.log(datos);
  
  let periodo_actual = document.getElementById('periodo').innerHTML.trim();
  

  let output = '';
  let caption = '';

  for (let salon in datos) {  
    [salon_nombre, salon_id, salon_uuid] = salon.split(";");
    
    lnk_boletines_salon = '';
    for (let index=1; index<=periodo_actual; index++) {
    lnk_boletines_salon +=  `
       <a href="${ruta}admin/notas/exportBoletinSalonPdf/${index}/${salon_uuid}/0" 
       class="w3-btn w3-black" target="_blank"><i class="fa-solid fa-file-pdf"></i>Preboletines p${index}</a> &nbsp; &nbsp;
      `;
    }
    
    caption = '<h2>Salon: '+salon_nombre+'</h2>';

    for (let estudiante in datos[salon]) {
      [estudiante_nombre, estudiante_id, estudiante_uuid]= estudiante.split(";");
      output += '<tr class="w3-theme-'+theme+'5"><td colspan=10>'+estudiante_nombre+'</td></tr>';
      cont = 1;
      for (let periodo in datos[salon][estudiante]) { 
      // fila de titulos de materia
      if (cont==1) {
        output += '<tr class="w3-theme-d3"><td>Per&iacute;odos</td>'; 
        for (let asignatura in datos[salon][estudiante][periodo]) {
          [asignatura_nombre, asignatura_abrev]= asignatura.split(";");
          output += '<td>' + asignatura_abrev + '</td>';
        }
        output += '</tr>';
        cont += 1;
      }

      lnk_boletin_estud_periodo = `
        <a href="${ruta}admin/notas/exportBoletinEstudiantePdf/${periodo}/${estudiante_uuid}/0" 
        class="w3-btn w3-black" target="_blank"><i class="fa-solid fa-file-pdf"></i>&nbsp;PB${periodo}</a>
        `;
      output += '<tr class="w3-theme-l3"><td>'+lnk_boletin_estud_periodo+'</td>'; 

      for (let asignatura in datos[salon][estudiante][periodo]) {  
        nota = datos[salon][estudiante][periodo][asignatura];
        [definitiva, plan_apoyo, nota_final, desempeno] = datos[salon][estudiante][periodo][asignatura].split(";");
        output += '<td>' + nota_final + '</td>';
      }

      output += '</tr>';
      }
    }
  }

  
  document.querySelector('#resultados').innerHTML = ` ${lnk_boletines_salon}
  <table id="myTable" class="w3-table w3-responsive w3-bordered">
    <caption id="tcaption" class="w3-left-align w3-bottombar w3-border-blue">${caption}</caption>
    <tbody id="tbody">${output}</tbody>
  </table>
  </div> 
  `;
  })
  .catch(
  error => console.log(error)
  );

}