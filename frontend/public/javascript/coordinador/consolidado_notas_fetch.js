
document.addEventListener('DOMContentLoaded', function () {
  console.clear();
  document.getElementById('salon-1').click();
});


function traer_data(id) {
let ruta = document.getElementById('public_path');
let theme = document.getElementById('theme');

fetch(ruta.innerHTML.trim()+'api/notas/notas_salon/'+id)
  .then((res) => res.json())
  
  .then(datos => {
      console.clear();
      //console.log(datos);

      let plantilla_tabla = 
        '<table id="myTable" class="w3-table w3-responsive w3-bordered">'
        + '<caption id="tcaption" class="w3-left-align w3-bottombar w3-border-blue">TEXTCAPTION</caption>'
        + '<tbody id="tbody">TEXTBODY</tbody>'
        + '</table>'
        + '</div>';

      let output = '';
      let caption = '';

      for (let salon in datos) {  
          let arrSalon = salon.split(";");
          caption = 'Salon: ' + arrSalon[0];

          for (let estudiante in datos[salon]) {  
              let arrEstudiante = estudiante.split(";"); //nombre;abrev 
              output += '<tr class="w3-theme-'+theme.toString().substr(0, 1)+'5"><td colspan=10>'+arrEstudiante[0]+'</td></tr>';
              cont = 1;
              for (let periodo in datos[salon][estudiante]) { 
                  // fila de titulos de materia
                  if (cont==1) {
                      output += '<tr class="w3-theme-d3"><td>P</td>'; 
                      for (let asignatura in datos[salon][estudiante][periodo]) {   
                          var arrAsignatura = asignatura.split(";"); //nombre;abrev 
                          output += '<td>' + arrAsignatura[1] + '</td>';
                      }
                      output += '</tr>';
                      cont += 1;
                  }


                  output += '<tr class="w3-theme-l3"><td>'+periodo+'</td>'; 
                  for (let asignatura in datos[salon][estudiante][periodo]) {  
                      nota = datos[salon][estudiante][periodo][asignatura];
                      var arrNotas = datos[salon][estudiante][periodo][asignatura].split(";"); //definitiva;planapoyo;final;desempeno
                      output += '<td>' + arrNotas[2] + '</td>';
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