var xs = [
    ["0", "4"],
    ["0", "3"],
    ["1", "2", "Beymsar Juanai", "--"],
    ["1", "7", "Arepsas Venezsolanas", "758a15999"]
];
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
            {"orderable": false, "searchable": false}, {"orderable": true}, {"orderable": true}, {"orderable": true}, {"orderable": true}, {"orderable": true}, {"orderable": true}]
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

    $('#src1').on('keyup', function () {
        tabla.columns(2).search(this.value).draw();
    });
    $("#clr1").click(function () {
        $("#src1").val('');
        tabla.columns(2).search('').draw();
    });

    $('#src2').on('keyup', function () {
        tabla.columns(3).search(this.value).draw();
    });

    $("#clr2").click(function () {
        $("#src2").val('');
        tabla.columns(3).search('').draw();
    });

    $('#src3').on('change', function () {
        tabla.columns(4).search(this.value).draw();
    });



    $('#src4').on('keyup', function () {
        tabla.columns(5).search(this.value).draw();
    });
    $("#clr3").click(function () {
        $("#src4").val('');
        tabla.columns(5).search('').draw();
    });

    $('#src5').on('change', function () {
        tabla.columns(6).search(this.value).draw();
    });
});