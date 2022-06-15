$(document).ready(function () {
  var tabla = $('#registros').DataTable({
    "dom": '<"toolbar">lrtip',
    "order": [[1, "asc"]],
    "language": {
      "lengthMenu": "Mostrando _MENU_ registros por página",
      "zeroRecords": "Ningun resultado obtenido",
      "info": "Pagina _PAGE_ de _PAGES_",
      "infoEmpty": "Sin informacion disponible",
      "infoFiltered": "(filtrado entre _MAX_ registros)"
    },
    "columns": [
      {"orderable": false, "searchable": false}, {"orderable": true}]
  });
  var x = '';
  $("div.toolbar").html(x);
  $('#bancoa').on('keyup', function () {
    tabla.columns(1).search(this.value).draw();
  });
  $("#clrbancoa").click(function () {
    $("#bancoa").val('');
    tabla.columns(1).search('').draw();
  });
});