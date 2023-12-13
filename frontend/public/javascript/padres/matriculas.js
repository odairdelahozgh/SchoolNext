document.addEventListener('DOMContentLoaded', function () {
  document.getElementById('btn-0').click();
});

function traer_data(estudiante_id) {
  let ruta_base = document.getElementById('public_path').innerHTML.trim();
  console.clear();

  // ========================================================================      
  const div_info_estudiante = document.getElementById("info_estudiante");
  fetch(ruta_base+'api/estudiantes/singleid/'+estudiante_id)
  .then((res) => res.json())
  .then(data_estudiante => {
    div_info_estudiante.innerHTML = template_datos_estud(data_estudiante, ruta_base, salon_nombre);
  });
  



  // matriculas
  const div_matriculas = document.getElementById('proceso_matriculas');
  if (1==document.getElementById('ver_matriculas').value) { 
    const arr_estado_mat = [
      '0: Bloqueado x Contabilidad',
      '1: No ha subido Documentos',
      '2: Documentos INCOMPLETOS',
      '3: Documentos EN REVISIÓN',
      '4: Documentos RECHAZADOS',
      '5: Documentos APROBADOS, Falta Asignar Número de Matrícula',
      '6: Documentos APROBADOS, Faltan FIRMAS del Acudiente',
      '7: Proceso Terminado',
    ];
    const estado_mat = '';
    if (data_estudiante.mes_pagado!=11) {
      estado_mat = arr_estado_mat[0];
    } else {
      estado_mat = 'Otro estado';
    }

    div_matriculas.innerHTML = `
    <div>
      <h2 class="w3-panel w3-theme w3-round-xlarge">Proceso de Matrículas 2024</h2>
      <h5>${estado_mat}<estado_mat/>
    </div>`;
  }

} //END-traer_data



function template_proceso_matriculas(data, ruta) {
  return `
    <h2 class="w3-panel w3-theme w3-round-xlarge">Proceso de Matrículas</h2>
  `;
} //END-template_proceso_matriculas


function template_datos_estud(data, ruta, salon_nombre) {
  return `
  <div class="w3-card-1">

    <header class="w3-container w3-light-blue  w3-round-xlarge">
      <h2 class="w3-panel w3-round-xlarge">[${data.id}] ${data.nombres} ${data.apellido1} ${data.apellido2} [${salon_nombre}]</h2>
    </header>

    <div class="w3-container">
      Última Referencia de Pago:<br> Mes ${nombreMes(data.mes_pagado)} de ${data.annio_pagado} 
    </div>

    <footer class="w3-container w3-light-blue">
      <h5></h5>
    </footer>
  </div>
  `;
} //END-template_datos_estud

