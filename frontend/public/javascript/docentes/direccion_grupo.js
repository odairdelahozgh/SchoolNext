document.addEventListener('DOMContentLoaded', function () {
  console.clear();
  document.getElementById('btn1').click();
});


function traer_data(salon_id) {
  const capa_datos = document.getElementById("capa_datos");
  getData(salon_id).then(res => {
    const elements = res.reduce((acc, data) => acc + template(data, salon_id), "");
    const tabla = `
      <div class="w3-panel"><button class="w3-button w3-circle w3-green" onclick="show_new_form(`+periodo_id+`, `+grado_id+`, `+asignatura_id+`)">+</button></div>`
      +`<table id="myTable" class="w3-table w3-responsive w3-striped w3-border w3-bordered">
        <tbody id="searchBody"></tbody>
          ${elements}
      </table>
    `;
    capa_datos.innerHTML = tabla;
  });
} //END-traer_data


function getData(salon_id) {
  let periodo = 1;
  let ruta = document.getElementById('public_path').innerHTML.trim()+'api/notas/notasprom_periodo_salon/'+periodo+'/'+salon_id;
  return fetch(ruta).then(res =>
    res.json()
  );
}//END-getData


function template(data, periodo_id, grado_id, asignatura_id) {
  let ruta_delete = document.getElementById('public_path').innerHTML.trim()+'admin/indicadores/del/';
  let ruta_edit   = document.getElementById('public_path').innerHTML.trim()+'admin/indicadores/edit_ajax/';
  
  href_delete = ruta_delete + data.id +'/docentes.listIndicadores.' +grado_id +'.' +asignatura_id;
  href_edit   = ruta_edit + data.id +'/docentes.listIndicadores.' +grado_id +'.' +asignatura_id;
  indicador_codigo = 'P'+data.periodo_id + '-' +data.codigo + ' ['+ data.valorativo +']';
  return `
    <tr class="item w3-theme-d4">
      <td id="${data.id}"> 
        <a href="${href_delete}" onclick="return confirm('Atención: ¿Quiere borrar Indicador ${data.codigo}?')">
        <i class="fa-solid fa-trash-can w3-large"></i></a>
        <b>${indicador_codigo}</b>
        <br>
        <p class="w3-hover-text-theme" onclick="show_edit_form(${data.id})">${data.concepto}</p>
      </td>
    </tr>
  `;
}//END-template
