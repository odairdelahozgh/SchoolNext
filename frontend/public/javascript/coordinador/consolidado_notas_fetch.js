
document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('btn-0').click();
});


function traer_data(id) {
let ruta = document.getElementById('public_path');
let theme = document.getElementById('theme');

fetch(ruta.innerHTML.trim()+'api/notas/notas_salon/'+id)
  .then((res) => res.json())
  
  .then(datos => {
      console.clear();
      console.log(datos);

      let plantilla_tabla = 
        '<table id="myTable"class="w3-table w3-responsive w3-bordered">'
        + '<caption id="tcaption" class="w3-left-align w3-bottombar w3-border-blue">TEXTCAPTION</caption>'
        + '<tbody id="tbody">TEXTBODY</tbody>'
        + '</table>'
        + '</div>';

      let output = '';
      let caption = '';

      for (let salon in datos) { 
          [salon_nombre, salon_id, salon_uuid] = salon.split(";");
          
          lnk_boletines_salon = '';
          for (let index=1; index<=5; index++) {
            lnk_boletines_salon +=  `
               <a href="${ruta.innerHTML.trim()}admin/notas/exportBoletinSalonPdf/${index}/${salon_uuid}" 
               class="w3-btn w3-black" target="_blank"><i class="fa-solid fa-file-pdf"></i> Boletines p${index}</a> &nbsp; &nbsp;
              `;
          }

          caption = ' Salon: ' + salon_nombre + '<br>' + lnk_boletines_salon;

          for (let estudiante in datos[salon]) {
              [estudiante_nombre, estudiante_id, estudiante_uuid]= estudiante.split(";");
              output += '<tr class="w3-theme-'+theme.toString().substr(0, 1)+'5"><td colspan=10>'+estudiante_nombre+'</td></tr>';
              cont = 1;
              for (let periodo in datos[salon][estudiante]) { // fila de titulos de materia
                  if (cont==1) {
                      output += '<tr class="w3-theme-d3"><td>P</td>'; 
                      for (let asignatura in datos[salon][estudiante][periodo]) {
                          [asignatura_nombre, asignatura_abrev]= asignatura.split(";");
                          output += '<td>' + asignatura_abrev + '</td>';
                      }
                      output += '</tr>';
                      cont += 1;
                  }

                  lnk_boletin_estud_periodo =  `
                      <a href="${ruta.innerHTML.trim()}admin/notas/exportBoletinEstudiantePdf/${periodo}/${estudiante_uuid}" 
                      class="w3-btn w3-black" target="_blank"><i class="fa-solid fa-file-pdf"></i> &nbsp;  &nbsp; P${periodo}</a>
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
      
      plantilla_tabla = plantilla_tabla.replace('TEXTBODY', output);
      plantilla_tabla = plantilla_tabla.replace('TEXTCAPTION', caption);
      //console.log(plantilla_tabla);
      document.querySelector('#resultados').innerHTML = plantilla_tabla;
  })
  .catch(
      error => console.log(error)
  );

}