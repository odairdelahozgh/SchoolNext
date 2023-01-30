
  document.addEventListener('DOMContentLoaded', function () {
    console.clear();
    document.getElementById('btn1').click();
  });

  function traer_data(periodo_id, grado_id, asignatura_id) {
    let ruta = document.getElementById('public_path');

    let todas_las_filas = '';
    let input_search = '';
    let btn_add = '<div class="w3-padding">'
                    + '<button id="btn_new_id" class="w3-btn w3-green" onclick="show_new_form()">btn_new_caption</button>'
                 +'</div>';
    let output = '';
    let cont = 1;
    let cod_id = '';

    fetch(ruta.innerHTML.trim()+'api/indicadores/list/'+periodo_id+'/'+grado_id+'/'+asignatura_id)
    .then((res) => res.json())

    .then(datos => {
      for (let reg in datos) {
        cod_id = '<span>' + datos[reg].periodo_id + '-' +datos[reg].codigo + ' ['+ datos[reg].valorativo +']' +'</span>';
        let row_data = '<b>P'+cod_id+'</b><br>'+datos[reg].concepto+'.';
        row_string = '<tr class="item w3-theme-'+(((cont % 2) == 0) ? "d1" : "d4")+'"><td> info </td></tr>';
        todas_las_filas = todas_las_filas + row_string.replace('info', row_data);
        cont = cont + 1;
      }

      btn_new = btn_add.replace('btn_new_id', 'btn_new_'+periodo_id+','+grado_id+','+asignatura_id);
      btn_new = btn_new.replace('btn_new_caption', 'Nuevo Indicador P'+periodo_id);
      input_search = '';
      output =  btn_new
                + '<table id="myTable" class="w3-table w3-responsive w3-striped w3-bordered">'
                + '  <tbody id="searchBody"> '+ todas_las_filas +' </tbody>'
                + '</table>';
      
      document.getElementById("capa_datos").innerHTML = output;
      document.getElementById("indicadors_annio").value = 2023;
      document.getElementById("indicadors_periodo_id").value = periodo_id;
      document.getElementById("indicadors_grado_id").value = grado_id;
      document.getElementById("indicadors_asignatura_id").value = asignatura_id;
      document.getElementById("indicadors_is_visible").value = 1;
      document.getElementById("form_new").action='/edsa-schoolnext/admin/indicadores/create_ajax/'+grado_id+'/'+asignatura_id;
      //document.getElementById('btn1').click();
    })
    .catch(
      error => {
        console.log(error);
        document.getElementById("capa_datos").innerHTML = error;
      }
    );    
  }


  function show_new_form() {
    w3.toggleShow('#formulario');
    /*
    let ruta = document.getElementById('public_path');
    fetch(ruta.innerHTML.trim() + 'api/indicadores/form')
    .then((res) => res.text())
    .then(datos => {
      document.getElementById("capa_repuesta").innerHTML = datos;
    })
    .catch(
      error => {
        console.log(error);
        document.getElementById("capa_repuesta").innerHTML = error;
      }
    );
    */
  }
