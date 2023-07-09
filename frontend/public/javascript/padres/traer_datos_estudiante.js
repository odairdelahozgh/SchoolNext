
document.addEventListener('DOMContentLoaded', function () {
  console.clear();
  document.getElementById('btn1').click();
});

function traer_data(estudiante_id, salon_nombre, periodo) {
  let ruta = document.getElementById('public_path');
  let schoolweb_public_path  = document.getElementById('schoolweb_public_path');
  const capa_datos = document.getElementById("capa_datos");
  
  fetch(ruta.innerHTML.trim()+'api/estudiantes/singleid/'+estudiante_id)
  .then((res) => res.json())
  .then(datos => {
      console.clear();
      console.log(datos);
      let datos_estud = template_datos_estud(datos, ruta.innerHTML.trim(), salon_nombre);
      let proceso_matriculas = template_proceso_matriculas(datos, ruta.innerHTML.trim());
      let seguimientos = template_seguimientos(datos, ruta.innerHTML.trim());
      //let boletines = template_boletines(datos, schoolweb_public_path.innerHTML.trim(), periodo);
      let boletines = template_boletines(datos, ruta.innerHTML.trim(), periodo);
      let planes_apoyo = template_planes_apoyo(datos, schoolweb_public_path.innerHTML.trim(), periodo);
      let reconocimientos = template_reconocimientos(datos, ruta.innerHTML.trim());
      
      let bloques = datos_estud;

      if (1==2) { // validar si está activo matriculas
        bloques += proceso_matriculas;
      }
      if (1==2) { // validar si está activo seguimientos
        bloques += seguimientos;
      }
      if (1==1) { // validar si está activo boletines
        bloques += boletines;
      }
      if (1==1) { // validar si está activo planes_apoyo
        bloques += planes_apoyo;
      }
      if (1==2) { // validar si está activo reconocimientos
        bloques += reconocimientos;
      }
      capa_datos.innerHTML = bloques;
  });
} //END-traer_data


function template_datos_estud(data, ruta, salon_nombre) {
  return `
  <div class="w3-container w3-card-1">

    <header class="w3-container w3-light-blue  w3-round-xlarge">
      <h2 class="w3-panel w3-round-xlarge">[${data.id}] ${data.nombres} ${data.apellido1} ${data.apellido2} [${salon_nombre}]</h2>
    </header>

    <div class="w3-container">
      <table class="w3-table">
      <tr>
        <td>Cuenta MS Teams:<br>
          <span class="w3-text-blue">${data.email_instit}@windsorschool.edu.co</span><br>
          Clave de Acceso: <span class="w3-text-blue">${data.clave_instit}</span>
        </td>
        <td></td>
        <td>Última Referencia de Pago:<br>
        Mes ${nombreMes(data.mes_pagado)} de ${data.annio_pagado}
        </td>
      </tr>
      </table>
    </div>

    <footer class="w3-container w3-light-blue">
      <h5> notificaciones...</h5>
    </footer>

  </div>
  `;
} //END-template_datos_estud


function template_proceso_matriculas(data, ruta) {
  return `
    <div class="w3-container">
      <h2 class="w3-panel w3-theme w3-round-xlarge">Proceso de Matrículas</h2>
    </div>
  `;
} //END-template_proceso_matriculas


function template_seguimientos(data, ruta) {
  return `
    <div class="w3-container">
      <h2 class="w3-panel w3-theme w3-round-xlarge">Seguimientos Intermedios</h2>
    </div>
  `;
} //END-template_seguimientos

function template_boletines(data, ruta, periodo) {
  let links = '';
  for (var i= 1; i<=periodo; i++) {
    links +=  `
    <a href="${ruta}admin/notas/exportBoletinEstudiantePdf/${i}/${data.uuid}" 
      class="w3-btn w3-black" target="_blank"><i class="fa-solid fa-file-pdf"></i> Boletin p${i}</a>
    `;
  }
  return `
    <div class="w3-container">
      <h2 class="w3-panel w3-theme w3-round-xlarge">Boletines</h2>
       ${links}
    </div>
  `;
} //END-template_boletines


// function template_boletines(data, ruta, periodo) {
//   let links = '';
//   for (var i= 1; i<=periodo; i++) {
//     links +=  `
//     <a href="${ruta}index.php/+/notas/boletines_padres?salon_id=${data.salon_id}&periodo=${i}&estudiante_id=${data.id}" 
//       class="w3-btn w3-black" target="_blank"><i class="fa-solid fa-file-pdf"></i> Boletin p${i}</a>
//     `;
//   }
//   return `
//     <div class="w3-container">
//       <h2 class="w3-panel w3-theme w3-round-xlarge">Boletines</h2>
//        ${links}
//     </div>
//   `;
// } //END-template_boletines


function template_planes_apoyo(data, ruta, periodo) {
  let links = '';
  //https://windsortemp.schoolnext.space/index.php/+/notas/PlanesApoyoFinalPadresPDF?id=11164
  for (var i= 1; i<=periodo; i++) {
    links +=  `
    <a href="${ruta}index.php/+/notas/PlanesApoyoFinalPadresPDF?id=${data.id}" 
      class="w3-btn w3-black" target="_blank"><i class="fa-solid fa-file-pdf"></i> pLANES DE AAPOYO  p${i}</a>
    `;
  }
  return `
    <div class="w3-container">
      <h2 class="w3-panel w3-theme w3-round-xlarge">Planes de Apoyo</h2>
       ${links}
    </div>
  `;
} //END-template_planes_apoyo


function template_reconocimientos(data, ruta) {
  return `
    <div class="w3-container">
      <h2 class="w3-panel w3-theme w3-round-xlarge">Reconocimientos</h2>
    </div>
  `;
} //END-template_reconocimientos


function nombreMes(mes) {
  const meses = ["Mes Indefinido", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
  return meses[mes];
}
