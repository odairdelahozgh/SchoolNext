
  document.addEventListener('DOMContentLoaded', function () {
    console.clear();
    document.getElementById('btn1').click();
    document.getElementById('formulario').style.display="none";
  });

  function traer_data(periodo_id, grado_id, asignatura_id) {
    let ruta = document.getElementById('public_path').innerHTML.trim()+'api/indicadores/list/'+periodo_id+'/'+grado_id+'/'+asignatura_id;

    let ruta_delete = document.getElementById('public_path').innerHTML.trim()+'admin/indicadores/delID/';
    let link_delete = '';
    let todas_las_filas = '';
    let input_search = '';
    let btn_add = '<div class="w3-padding">'
                    + '<button id="btn_new_id" class="w3-btn w3-green" onclick="show_new_form()">btn_new_caption</button>'
                 +'</div>';
    let output = '';
    let cont = 1;
    let cod_id = '';
    let row_data = '';

    fetch(ruta)
    .then((res) => res.json())

    .then(datos => {
      for (let indicador in datos) {
        indicador_codigo = '<span>' + datos[indicador].periodo_id + '-' +datos[indicador].codigo + ' ['+ datos[indicador].valorativo +']' +'</span>';
        href_delete = ruta_delete +datos[indicador].id +'/docentes.listIndicadores.' +grado_id +'.' +asignatura_id;
        
        link_delete = '<a href="'+href_delete+'"><i class="fa-solid fa-trash-can w3-large"></i></a>';

        row_data = '<b>P' +indicador_codigo +'</b><br>'
                    +link_delete +'  ' +datos[indicador].concepto +'.';
        
        row_string = '<tr class="item w3-theme-'+(((cont % 2) === 0) ? "d1" : "d4")+'"><td> datos </td></tr>';
        todas_las_filas = todas_las_filas + row_string.replace('datos', row_data);

        cont = cont + 1;
      } // fin del recorrido de datos

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
      document.getElementById("form_new").action='/admin/indicadores/create_ajax';
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
    w3.hide('#lista_indicadores');
    w3.show('#formulario');
  }
