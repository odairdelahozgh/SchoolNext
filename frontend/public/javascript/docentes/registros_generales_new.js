
  document.addEventListener('DOMContentLoaded', function () {
    console.clear();
    //document.getElementById('btn1').click();
    document.getElementById('formulario').style.display="none";
  });


  function show_new_form(estudiante_id, grado_id, salon_id, user_id) {
    w3.hide('#lista_estudiantes');
    w3.show('#formulario');
    // grado_id created_at, updated_at
    document.getElementById('registrosgens_estudiante_id').value = estudiante_id;
    document.getElementById('registrosgens_annio').value = 2023; // OJO CAMBIAR ODAIR
    document.getElementById('registrosgens_grado_id').value = grado_id;
    document.getElementById('registrosgens_salon_id').value = salon_id;
    document.getElementById('registrosgens_created_by').value = user_id;
    document.getElementById('registrosgens_updated_by').value = user_id;
  }

  function cancelar() {
    w3.show('#lista_estudiantes');
    w3.hide('#formulario');
  }