document.addEventListener('DOMContentLoaded', function () {
  console.clear();
  document.getElementById('form_new').style.display="none";
  document.getElementById('form_edit').style.display="none";
  document.getElementById('list_estudiantes').style.display="none";
});

function show_lista_estudiantes() {
  w3.show('#list_estudiantes');

  w3.hide('#list_index');
  w3.hide('#form_new');
  w3.hide('#form_edit');
}

function show_new_form(estudiante_id, grado_id, salon_id, user_id) {
  var dt = new Date();
  document.getElementById('registrosgens_estudiante_id').value = estudiante_id;
  document.getElementById('registrosgens_annio').value = dt.getFullYear();
  document.getElementById('registrosgens_grado_id').value = grado_id;
  document.getElementById('registrosgens_salon_id').value = salon_id;
  document.getElementById('registrosgens_created_by').value = user_id;
  document.getElementById('registrosgens_updated_by').value = user_id;

  w3.show('#form_new');

  w3.hide('#list_index');
  w3.hide('#list_estudiantes');
  w3.hide('#form_edit');
}



function show_edit_form(reg_id) {
  //console.clear();
  let ruta = document.getElementById('public_path').innerHTML.trim()+'api/registros_gen/singleid/'+reg_id;
  fetch(ruta)
  .then((res) => res.json())
  .then(datos => {
    console.log(datos);
    document.getElementById('registrosgens_id').value = datos.id;
    document.getElementById('registrosgens_uuid').value = datos.uuid;
    document.getElementById('registrosgens_estudiante_id').value = datos.estudiante_id;
    document.getElementById('registrosgens_annio').value = datos.annio;
    document.getElementById('registrosgens_periodo_id').value = datos.periodo_id;
    document.getElementById('registrosgens_grado_id').value = datos.grado_id;
    document.getElementById('registrosgens_salon_id').value = datos.salon_id;
    document.getElementById('registrosgens_fecha').value = datos.fecha;
    document.getElementById('registrosgens_asunto').value = datos.asunto;
    document.getElementById('registrosgens_acudiente').value = datos.acudiente;
    document.getElementById('registrosgens_foto_acudiente').value = datos.foto_acudiente;
    document.getElementById('registrosgens_director').value = datos.director;
    document.getElementById('registrosgens_foto_director').value = datos.foto_director;
    document.getElementById('registrosgens_created_at').value = datos.created_at;
    document.getElementById('registrosgens_updated_at').value = datos.updated_at;
    document.getElementById('registrosgens_created_by').value = datos.created_by;
    document.getElementById('registrosgens_updated_by').value = datos.updated_by;
    document.getElementById('registrosgens_periodo_id').focus();    
  })
  .catch(
    error => {
      //console.log(error);
      //document.getElementById("form_edit").innerHTML = error;
    }
  );
  w3.show('#form_edit');

  w3.hide('#list_index');
  w3.hide('#list_estudiantes');
  w3.hide('#form_new');
}

// function show_edit_form(estudiante_id, grado_id, salon_id, user_id) {
//   var dt = new Date();
//   w3.show('#form_edit');

//   w3.hide('#list_estudiantes');
//   w3.hide('#list_index');
//   w3.hide('#form_new');
// }

function cancelar() {
  w3.show('#list_index');
  
  w3.hide('#form_new');
  w3.hide('#form_edit');
}