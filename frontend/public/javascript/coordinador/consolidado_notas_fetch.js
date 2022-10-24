// FETCH DATA
function traer_data(id) {
    document.getElementById(id)
    fetch('http://schoolnext.local.com/api/notas/notas_salon/'+id)
    .then((res) => res.json())
    
    .then(datos => {
        console.clear();
        console.log(datos);
        let plantilla_tabla = 
        ` '
          <table id="myTable" class="w3-table w3-responsive w3-striped w3-bordered">'
        '    <caption id="tcaption" class="w3-left-align w3-bottombar w3-border-blue">TEXTCAPTION</caption>'
        '    <tbody id="tbody">TEXTBODY</tbody>'
        '</table>'
    '</div>`;

        let output = '';
        let caption = '';

        for (let salon in datos) {  
            let arrSalon = salon.split(";");
            caption = 'Salón: ' + arrSalon[0];

            for (let estudiante in datos[salon]) {  
                let arrEstudiante = estudiante.split(";"); //nombre;abrev 
                output += '<tr><td colspan=10>'+arrEstudiante[0]+'</td></tr>';
                cont = 1;
                for (let periodo in datos[salon][estudiante]) { 
                    // fila de titulos de materia
                    if (cont==1) {
                        output += '<tr><td>P</td>'; 
                        for (let asignatura in datos[salon][estudiante][periodo]) {   
                            var arrAsignatura = asignatura.split(";"); //nombre;abrev 
                            output += '<td>' + arrAsignatura[1] + '</td>';
                        }
                        output += '</tr>';
                        cont += 1;
                    }


                    output += '<tr><td>'+periodo+'</td>'; 
                    for (let asignatura in datos[salon][estudiante][periodo]) {  
                        nota = datos[salon][estudiante][periodo][asignatura];
                        var arrNotas = datos[salon][estudiante][periodo][asignatura].split(";"); //definitiva;planapoyo;final;desempeño
                        output += '<td>' + arrNotas[2] + '</td>';
                    }

                    output += '</tr>';
                }
            }
        }
        document.querySelector('#salon').innerHTML = caption;
        document.querySelector('#tbody').innerHTML = output;
        document.querySelector('#tcaption').innerHTML = caption;
    })
    .catch(
        error => console.log(error)
    );
    
/*     $(document).ready( function () {
        $('.w3-table').DataTable();
    } ); */

}