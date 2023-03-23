
document.addEventListener('DOMContentLoaded', function () {
  console.clear();
  document.getElementById('btn1').click();
});

function show_edit_form() {
  w3.show('#form_edit');

  w3.hide('#form_new');
  w3.hide('#list_index');
}//END-show_edit_form

function show_new_form(periodo_id, grado_id, asignatura_id) {
  w3.hide('#form_edit');
  w3.hide('#list_index');
  w3.show('#form_new');
  
  var dt = new Date();
  const frm = document.getElementById("frm_new");
// 'annio', 'periodo_id', 'grado_id', 'asignatura_id', 
// 'codigo', 'concepto', 'valorativo', 'is_visible', 'is_active', 'created_at', 'updated_at', 'created_by', 'updated_by'
  document.getElementById("titulo_indicador_new").innerHTML = 'Nuevo Indicador';
  
  frm.indicadors_annio.value = dt.getFullYear();
  frm.indicadors_periodo_id.value    = periodo_id;
  frm.indicadors_grado_id.value      = grado_id;
  frm.indicadors_asignatura_id.value = asignatura_id;
  frm.indicadors_codigo.value        = '';
  frm.indicadors_concepto.value      = '';
  frm.indicadors_valorativo.value    = 'Recomendación';

  frm.indicadors_is_visible.value = 1;
  frm.indicadors_is_active.value  = 1;
  frm.indicadors_created_by.value = user_id;
  frm.indicadors_updated_by.value = user_id;

}//END-show_new_form

function cancelar() {
  w3.show('#list_index');
  w3.hide('#form_new');
  w3.hide('#form_edit');
}//END-cancelar

function traer_data(periodo_id, grado_id, asignatura_id) {
  const capa_datos = document.getElementById("capa_datos");
  getData(periodo_id, grado_id, asignatura_id).then(res => {
    const elements = res.reduce((acc, data) => acc + template(data, periodo_id, grado_id, asignatura_id), "");
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

function template(data, periodo_id, grado_id, asignatura_id) {
  let ruta_delete = document.getElementById('public_path').innerHTML.trim()+'admin/indicadores/del/';
  href_delete = ruta_delete +data.id +'/docentes.listIndicadores.' +grado_id +'.' +asignatura_id;
  indicador_codigo = 'P'+data.periodo_id + '-' +data.codigo + ' ['+ data.valorativo +']';
  return `
    <tr class="item w3-theme-d4">
      <td id="${data.id}"> 
        <a href="${href_delete}" onclick="return confirm('Atención: ¿Quiere borrar Indicador ${data.codigo}?')">
        <i class="fa-solid fa-trash-can w3-large"></i></a>
        <b>${indicador_codigo}</b>
        <br>
        <p>${data.concepto}</p>
      </td>
    </tr>
  `;
}//END-template

function getData(periodo_id, grado_id, asignatura_id) {
  let ruta = document.getElementById('public_path').innerHTML.trim()+'api/indicadores/list/'+periodo_id+'/'+grado_id+'/'+asignatura_id;
  return fetch(ruta).then(res =>
    res.json()
  );
}//END-getData
