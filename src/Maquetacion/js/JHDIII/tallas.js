$(document).ready(function () {
  var tabla = $('#registros').DataTable({
    "dom": '<"toolbar">lrtip', //reemplazar input de busqueda original
    //"order": [[0,]],//[[1, "asc"]], //ordenar por la segunda columna
    "language": {
      "lengthMenu": "Mostrando _MENU_ registros por página",
      "zeroRecords": "Ningun resultado obtenido",
      "info": "Pagina _PAGE_ de _PAGES_",
      "infoEmpty": "Sin informacion disponible",
      "infoFiltered": "(filtrado entre _MAX_ registros)"
    },
    "columns": [
      {"orderable": false, "searchable": false},
      {"orderable": false}
    ]
  });
  var x = '';//por si queires añadir algo...
  $("div.toolbar").html(x);
  //busqueda
  $('#talla').on('keyup', function () {
    tabla.columns(1).search(this.value).draw();
  });

  //permitir boton de reset en los inputs
  $("#clrtalla").click(function () {
    $("#talla").val('');
    tabla.columns(1).search('').draw();
  });
});
