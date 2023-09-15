document.addEventListener('DOMContentLoaded', function () {
  console.clear();
  document.getElementById('btn-0').click();
});

function traer_data(estudiante_id, salon_nombre, periodo) {
  let ruta_base = document.getElementById('public_path').innerHTML.trim();
  console.clear();

  // ========================================================================      
  const div_info_estudiante = document.getElementById("info_estudiante");
  fetch(ruta_base+'api/estudiantes/singleid/'+estudiante_id)
  .then((res) => res.json())
  .then(data_estudiante => {
    
    div_info_estudiante.innerHTML = template_datos_estud(data_estudiante, ruta_base, salon_nombre);
    
    // LINKS PARA DESCARGAR BOLETINES
    const periodo_boletines = document.getElementById('periodo_boletines').value;
    div_boletines = document.getElementById('boletines');
    if (1==document.getElementById('ver_boletines').value) {
      div_boletines.innerHTML = template_boletines(data_estudiante, ruta_base, periodo_boletines);
    }

  });

  
  // ========================================================================      
  const periodo_seguimientos = document.getElementById('periodo_seguimientos').value;
  const div_seguimientos = document.getElementById('seguimientos');
  if (1==document.getElementById('ver_seguimientos').value) { 
    getDataSeguimientos(ruta_base, estudiante_id, periodo_seguimientos)
    .then(res => {
      const elements = res.reduce((acc, data_seguimientos) => acc + template_seguimientos(ruta_base, data_seguimientos), "");
      const botones = elements;

      if (botones.length>0) { 
        div_seguimientos.innerHTML = `
        <div>
          <h2 class="w3-panel w3-theme w3-round-xlarge">Seguimientos Intermedios</h2>
          ${botones}
        </div>`;
      } else { 
        div_seguimientos.innerHTML =  `
        <div>
          <h2 class="w3-panel w3-theme w3-round-xlarge">Seguimientos</h2>
          <span class="w3-text-blue">No tiene Seguimientos en el presente periodo</span>
        </div>`; 
      }
    });
  } //END::SEGUIMIENTOS-INTERMEDIOS
  
  function getDataSeguimientos(ruta_base, estudiante_id, periodo_id) {
    ruta = ruta_base+'api/seguimientos/by_estudiante_periodo/'+estudiante_id+'/'+periodo_id;
    return fetch(ruta).then(res => res.json() );
  }//END-getDataPlanesApoyo

  function template_seguimientos(ruta_base, data) {
    let ruta_descarga_seguimientos  = ruta_base+'admin/seguimientos/exportSeguimientosRegistroPdf/'+data.uuid;
    console.log('periodo: '+data.periodo_id);
    return `
      <a href="${ruta_descarga_seguimientos}" 
        class="w3-btn w3-black" 
        target="_blank">
        <i class="fa-solid fa-file-pdf"></i> ${data.asignatura_nombre} P${data.periodo_id}
      </a>
    `;
  } //END-template_seguimientos



  // ========================================================================      
  const periodo_planes_apoyo = document.getElementById('periodo_planes_apoyo').value;
  const div_planes_apoyo = document.getElementById('planes_apoyo');
  if (1==document.getElementById('ver_planes_apoyo').value) { 
    getDataPlanesApoyo(ruta_base, estudiante_id, periodo_planes_apoyo)
    .then(res => {
      const elements = res.reduce((acc, data_planes_apoyo) => acc + template_planes_apoyo(ruta_base, data_planes_apoyo), "");
      const botones = elements;

      if (botones.length>0) { 
        div_planes_apoyo.innerHTML = `
        <div>
          <h2 class="w3-panel w3-theme w3-round-xlarge">Planes de Apoyo</h2>
          ${botones}
        </div>`;
      } else { 
        div_planes_apoyo.innerHTML =  `
        <div>
          <h2 class="w3-panel w3-theme w3-round-xlarge">Planes de Apoyo</h2>
          <span class="w3-text-blue">No tiene Planes de Apoyo en el presente periodo</span>
        </div>`; 
      }
    });
  } //END::PLANES-DE-APOYO 
  

} //END-traer_data




function getDataPlanesApoyo(ruta_base, estudiante_id, periodo_id) {
  ruta = ruta_base+'api/planes_apoyo/by_estudiante_periodo/'+estudiante_id+'/'+periodo_id;
  return fetch(ruta).then(res => res.json() );
}//END-getDataPlanesApoyo

function template_planes_apoyo(ruta_base, data) {
  let ruta_descarga_plan_apoyo  = ruta_base+'admin/planes_apoyo/exportPlanesApoyoRegistroPdf/'+data.uuid;
  console.log('periodo: '+data.periodo_id);
  return `
    <a href="${ruta_descarga_plan_apoyo}" 
       class="w3-btn w3-black" 
       target="_blank">
       <i class="fa-solid fa-file-pdf"></i> ${data.asignatura_nombre} P${data.periodo_id}
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
          <td>
          </td>
          <td>Última Referencia de Pago:<br> Mes ${nombreMes(data.mes_pagado)} de ${data.annio_pagado} 
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


function template_boletines(estudiante, ruta_base, periodo_actual) {
  let links = '';
  let mes_req = [];
  mes_req[1] = 4;
  mes_req[2] = 6;
  mes_req[3] = 9;
  mes_req[4] = 11;
  mes_req[5] = 11;

  for (var i= 1; i<=periodo_actual; i++) {
    if (estudiante.mes_pagado>=mes_req[i]) {
      links +=  `
      <a href="${ruta_base}admin/notas/exportBoletinEstudiantePdf/${i}/${estudiante.uuid}" 
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


function template_reconocimientos(data, ruta_base) {
  return `
    <h2 class="w3-panel w3-theme w3-round-xlarge">Reconocimientos</h2>
  `;
} //END-template_reconocimientos


function nombreMes(mes) {
  const meses = ["Mes Indefinido", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
  return meses[mes];
}