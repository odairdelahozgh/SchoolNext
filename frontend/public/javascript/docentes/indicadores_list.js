
  document.addEventListener('DOMContentLoaded', function () {
    console.clear();
    document.getElementById('btn1').click();
    document.getElementById('formulario').style.display="none";
  });

  function traer_data(periodo_id, grado_id, asignatura_id) {
    document.getElementById("capa_datos").innerHTML = '';

    // AÑADIR BOTÓN
    var btn_template = document.querySelector('#btn_new_template');
    btn_nuevo = btn_template.content.querySelector("#id_btn_new");
    btn_nuevo.textContent = "Nuevo Indicador P"+periodo_id;

    var capa_datos = document.querySelector("#capa_datos");
    var clone = document.importNode(btn_template.content, true);
    capa_datos.appendChild(clone);

    // AÑADIR TABLA
    var template_table = document.querySelector('#table_template');
    //table_body = template_table.content.querySelector("#searchBody");
    //table_body.textContent = "Nuevo Indicador P"+periodo_id;

    var capa_datos = document.querySelector("#capa_datos");
    var clone = document.importNode(template_table.content, true);
    capa_datos.appendChild(clone);
    

    let ruta = document.getElementById('public_path').innerHTML.trim()+'api/indicadores/list/'+periodo_id+'/'+grado_id+'/'+asignatura_id;
    let ruta_delete = document.getElementById('public_path').innerHTML.trim()+'admin/indicadores/del/';
    let link_delete = '';
    let todas_las_filas = '';
    let input_search = '';
    let output = '';
    let cont = 1;
    let cod_id = '';
    let row_data = '';

    fetch(ruta)
    .then((res) => res.json())

    .then(datos => {
      for (let indicador in datos) {
        //indicador_codigo = '<span>' + datos[indicador].periodo_id + '-' +datos[indicador].codigo + ' ['+ datos[indicador].valorativo +']' +'</span>';
        href_delete = ruta_delete +datos[indicador].id +'/docentes.listIndicadores.' +grado_id +'.' +asignatura_id;
        link_delete = '<a href="'+href_delete+'"><i class="fa-solid fa-trash-can w3-large"></i></a>';
        
        var template_row = document.querySelector('#new_row_template');

        td_row_title = template_row.content.querySelector("b");
        td_row_title.textContent = datos[indicador].periodo_id + '-' +datos[indicador].codigo + ' ['+ datos[indicador].valorativo +']';

        td_row_lnk_delete = template_row.content.querySelector("span");
        //td_row_lnk_delete.textContent = link_delete;
        
        td_row_p = template_row.content.querySelector("p");
        td_row_p.textContent = datos[indicador].concepto;
        
        var capa_datos = document.querySelector("#capa_datos");
        var clone = document.importNode(template_table.content, true);
        capa_datos.appendChild(clone);
        
        
        var table_body = document.querySelector("#searchBody");
        var clone = document.importNode(template_row.content, true);
        table_body.appendChild(clone);

        cont = cont + 1;
      } // fin del recorrido de datos
      
      
      document.getElementById("indicadors_annio").value = 2023;
      document.getElementById("indicadors_periodo_id").value = periodo_id;
      document.getElementById("indicadors_grado_id").value = grado_id;
      document.getElementById("indicadors_asignatura_id").value = asignatura_id;
      document.getElementById("indicadors_is_visible").value = 1;
      document.getElementById("form_new").action='/admin/indicadores/create_ajax';

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

  function cancelar() {
    w3.show('#lista_indicadores');
    w3.hide('#formulario');
  }