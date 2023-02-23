document.addEventListener('DOMContentLoaded', function () {
  console.clear();
  document.getElementById('form_new').style.display="none";
  document.getElementById('form_edit').style.display="none";
  document.getElementById('lista_estudiantes').style.display="none";
});

function show_lista_estudiantes() {
  w3.show('#lista_estudiantes');

  w3.hide('#list_index');
  w3.hide('#form_new');
  w3.hide('#form_edit');
}

function show_new_form(estudiante_id, grado_id, salon_id, user_id) {
  var dt = new Date();
  document.getElementById('registrodesempacads_estudiante_id').value = estudiante_id;
  document.getElementById('registrodesempacads_annio').value = dt.getFullYear();
  document.getElementById('registrodesempacads_fecha').value = dt;
  document.getElementById('registrodesempacads_grado_id').value = grado_id;
  document.getElementById('registrodesempacads_salon_id').value = salon_id;
  document.getElementById('registrodesempacads_created_by').value = user_id;
  document.getElementById('registrodesempacads_updated_by').value = user_id;

  w3.show('#form_new');

  w3.hide('#list_index');
  w3.hide('#lista_estudiantes');
  w3.hide('#form_edit');
}


function show_edit_form(estudiante_id, grado_id, salon_id, user_id) {
  w3.show('#form_edit');

  w3.hide('#lista_estudiantes');
  w3.hide('#list_index');
  w3.hide('#form_new');
}

function cancelar() {
  w3.show('#list_index');
  
  w3.hide('#form_new');
  w3.hide('#form_edit');
}