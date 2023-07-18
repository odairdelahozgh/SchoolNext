document.addEventListener('DOMContentLoaded', function () {
  console.clear();
  document.getElementById('btn1').click();
});

function traer_data(estudiante_id, salon_nombre, periodo_actual) {
  let ruta_base = document.getElementById('public_path').innerHTML.trim();
  console.clear();
  // ========================================================================      
  const info_estudiante = document.getElementById("info_estudiante");
  fetch(ruta_base+'api/estudiantes/singleid/'+estudiante_id)
  .then((res) => res.json())
  .then(datos => {
    info_estudiante.innerHTML = template_datos_estud(datos, ruta_base, salon_nombre);
  });

  // ========================================================================      
  //const ver_planes_apoyo = document.getElementById('ver_planes_apoyo').value;
  if (1==document.getElementById('ver_planes_apoyo').value) { 
    getDataPlanesApoyo(ruta_base, estudiante_id, periodo_actual)
    .then(res => {
      const elements = res.reduce((acc, data) => acc + template_planes_apoyo(ruta_base, data), "");
      const botones = elements;

      if (botones.length>0) { 
        planes_apoyo.innerHTML = `
        <div>
          <h2 class="w3-panel w3-theme w3-round-xlarge">Planes de Apoyo</h2>
          ${botones}
        </div>`;
      } else { 
        planes_apoyo.innerHTML =  `
        <div>
          <h2 class="w3-panel w3-theme w3-round-xlarge">Planes de Apoyo</h2>
          <span class="w3-text-blue">No tiene Planes de Apoyo en el presente periodo</span>
        </div>`; }
    });
  }
  


} //END-traer_data

function getDataPlanesApoyo(ruta_base, estudiante_id, periodo_id) {
  ruta = ruta_base+'api/planes_apoyo/by_estudiante_periodo/'+estudiante_id+'/'+periodo_id;
  //console.log(ruta);
  return fetch(ruta).then(res => res.json() );
}//END-getDataPlanesApoyo

function template_planes_apoyo(ruta_base, data) {
  let ruta_descarga_plan_apoyo  = ruta_base+'admin/planes_apoyo/exportPlanesApoyoEstudiantePdf/'+data.uuid;
  return `
    <a href="${ruta_descarga_plan_apoyo}" 
       class="w3-btn w3-black" 
       target="_blank">
       <i class="fa-solid fa-file-pdf"></i> P.A. ${data.asignatura_nombre} 
    </a>
  `;
} //END-template_planes_apoyo


function template_datos_estud(data, ruta, salon_nombre) {
  return `
  <div class="w3-card-1">

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
    <h2 class="w3-panel w3-theme w3-round-xlarge">Proceso de Matrículas</h2>
  `;
} //END-template_proceso_matriculas


function template_seguimientos(data, ruta) {
  return `
    <h2 class="w3-panel w3-theme w3-round-xlarge">Seguimientos Intermedios</h2>
  `;
} //END-template_seguimientos

function template_boletines(data, ruta, periodo) {
  let links = '';
  let mes_req = [];
  mes_req[1] = 4;
  mes_req[2] = 6;
  mes_req[3] = 9;
  mes_req[4] = 11;
  mes_req[5] = 11;

  for (var i= 1; i<=periodo; i++) {
    if (data.mes_pagado>=mes_req[i]) {
      links +=  `
      <a href="${ruta}admin/notas/exportBoletinEstudiantePdf/${i}/${data.uuid}" 
      class="w3-btn w3-blue" alt="Descarga PDF" target="_blank"><i class="fa-solid fa-file-pdf"></i> Boletin p${i}</a>
      `;
    } else {
      links +=  `
      <span class="w3-btn w3-grey" title="bloqueado"> <i class="fa-solid fa-file-pdf"></i> Boletin p${i} </span>
      `;
    }
  }
  return `
    <h2 class="w3-panel w3-theme w3-round-xlarge">Boletines</h2>
    ${links}
  `;
} //END-template_boletines

function template_reconocimientos(data, ruta) {
  return `
    <h2 class="w3-panel w3-theme w3-round-xlarge">Reconocimientos</h2>
  `;
} //END-template_reconocimientos


function nombreMes(mes) {
  const meses = ["Mes Indefinido", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
  return meses[mes];
}