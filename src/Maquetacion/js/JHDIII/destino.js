$(document).ready(function () {
  var tabla = $('#registros').DataTable({
    "dom": '<"toolbar">lrtip', //reemplazar input de busqueda original
    "order": [[1, "asc"]], //ordenar por la segunda columna
    "language": {
      "lengthMenu": "Mostrando _MENU_ registros por página",
      "zeroRecords": "Ningun resultado obtenido",
      "info": "Pagina _PAGE_ de _PAGES_",
      "infoEmpty": "Sin informacion disponible",
      "infoFiltered": "(filtrado entre _MAX_ registros)"
    },
    "columns": [
      {"orderable": false, "searchable": false}, {"orderable": true}, {"orderable": true}]
  });
  var x = '';
  $("div.toolbar").html(x);
  $('#src0').on('keyup', function () {
    tabla.columns(1).search(this.value).draw();
  });
  $("#clr0").click(function () {
    $("#src0").val('');
    tabla.columns(1).search('').draw();
  });
  $('#src1').on('change', function () {
    tabla.columns(2).search(this.value).draw();
  });
});