
function myFunctionFilter() {
  var input, filter, arrayDeFilter, table, tr, td, i, td_i, td_ii, hit1, hit2;
  /*   function replaceStr(str, find, replace) {
    for (var i = 0; i < find.length; i++) {
      str = str.replace(new RegExp(find[i], 'gi'), replace[i]);
    }
    return str;
  } 
  */
 input = document.getElementById("inputSearch");
 filter = input.value.toUpperCase().trim();
 arrayDeFilter = filter.split(" ");
 /*
 var find = ['Á','É','Í','Ó','Ú'];
 var replace = ['A','E','I','O','U'];
 for (i = 0; i < arrayDeFilter.length; i++) {
   arrayDeFilter[i] = replaceStr(arrayDeFilter[i], find, replace);
  } 
*/
table = document.getElementById("myTable");
tr = table.getElementsByClassName("item");
for (tri = 0; tri < tr.length; tri++) {
  td = tr[tri].getElementsByClassName("searchTdata");
    hit1 = 0;
    for (td_i = 0; td_i < td.length; td_i++) {
      hit2 = 0;
      for (td_ii = 0; td_ii < arrayDeFilter.length; td_ii++) {
        if (td[td_i].innerText.toUpperCase().indexOf(arrayDeFilter[td_ii].toUpperCase()) > -1) {
          hit2 += 1;
        }
      }
      if (hit2==arrayDeFilter.length) { 
        hit1 += 1;
      }
    }
    
    if (hit1>=1) {
      tr[tri].style.display = "";
    } else {
      tr[tri].style.display = "none";
    }
  }
}

document.getElementById("inputSearch").addEventListener("keyup", myFunctionFilter);
//console.log('cambió');