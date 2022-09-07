var m = NaN;
var n = NaN;
var tt = 10;
$.fn.dataTable.ext.search.push(function (settings, data, dataIndex) {
  var min = m;
  var max = n;
  var t = data[tt].split("-"); //dia mes anio
  var mydate = new Date(t[2], t[1] - 1, t[0]);
  if (
    (isNaN(min) && isNaN(max)) ||
    (isNaN(min) && mydate <= max) ||
    (min <= mydate && isNaN(max)) ||
    (min <= mydate && mydate <= max)
  ) {
    return true;
  }
  return false;
});
$(document).ready(function () {
  var tabla = $("#registros").DataTable({
    dom: '<"top"B>rt<"bottom"ip>',
    columns: [
      { orderable: false, searchable: false, className: "select-checkbox" },
      { orderable: false, visible: false },
      { orderable: true },
      { orderable: true },
      { orderable: false },
      { orderable: false },
      { orderable: true },
      { orderable: true },
      { orderable: true, visible: false },
      { orderable: true, visible: false },
      { orderable: true },
      { orderable: true },
      { orderable: true },
      { orderable: false, visible: false },
    ],
    initComplete: function () {
      // Need to wait for a split second, I find this is actually
      // common with DataTables events, its almost as if you need
      // to wait for the elements in the DOM to fully "settle"..
      setTimeout(tr, 1);
    },
    order: [[10, "asc"]],
    language: {
      lengthMenu: "_MENU_ registros",
      zeroRecords: "Ningun resultado obtenido",
      info: "Obtenido: _TOTAL_ registros",
      infoEmpty: "Obtenido: 0 registros",
      infoFiltered: "de _MAX_",
      paginate: {
        next: "<b>&#x276f;</b>",
        previous: "<b>&#x276e;</b>",
      },
      select: {
        rows: {
          _: "Seleccionando: %d",
          0: "",
        },
      },
      buttons: {
        pageLength: {
          _: "%d en pagina",
        },
      },
    },
    select: {
      style: "multi", //'os' uno a la vez salvo usando ctr, 'single' solo uno y no mas
      selector: "td", //'td:first-child' solo desde la primera columna  TAMBIEN SE PUEDE NO LA ULltima columna,,,
    },
    buttons: {
      dom: {
        button: {
          className: "",
        },
      },
      buttons: [
        {
          className: "btn btn-outline-success",
          extend: "selectedSingle",
          text: '<i class="fas fa-edit"></i> Edita',
          action: function (e, dt, button, config) {
            var idpedido = -1;
            idpedido = numeral(dt.row(".selected").data()[1]);
            window.open("frm_alta_mod.php?v=" + idpedido, "_self");
          },
        },
        {
          className: "btn btn-outline-danger",
          extend: "selected",
          text: '<i class ="fas fa-trash"></i> Eliminar',
          action: function (e, dt, button, config) {
            var x = window.confirm(
              "¿Realmente desea eliminar registros seleccionados?"
            );
            if (x) {
              iterativo(dt, "0");
            }
          },
        },
        {
          className: "btn btn-outline-secondary",
          extend: "selectedSingle",
          text: '<i class ="fas fa-receipt"></i> Recibo',
          action: function (e, dt, button, config) {
            var idpedido = -1;
            idpedido = numeral(dt.row(".selected").data()[1]);
            window.open(
              "../../Reporte/LaTeX/Recibo.php?a=" + idpedido,
              "_blank"
            );
          },
        },
        {
          className: "btn btn-outline-info",
          extend: "selectedSingle",
          text: '<i class ="fas fa-info"></i> Ver detalle',
          action: function (e, dt, button, config) {
            $.each(dt.rows(".selected").data(), function () {
              //con esto iteramos en todo?//no se si esta en ajax optimizado para 1
              var idpedido = numeral(this[1]);
              $.ajax({
                url: "../plantilla/ajax.php",
                data: {
                  a: "detalle",
                  id: idpedido,
                },
                type: "post",
                beforeSend: function () {
                  $("#editable").empty();
                },
                success: function (output) {
                  $("#editable").append(output);
                },
              });
            });
            $("#detalla").modal("toggle");
          },
        },
        {
          className: "btn btn-outline-secondary",
          extend: "selected",
          text: '<i class ="fas fa-arrow-circle-down"></i> Itinerario',
          action: function (e, dt, button, config) {
            var vector = [];
            $.each(dt.rows(".selected").data(), function () {
              vector.push(numeral(this[1])); //la columna donde esta
            });
            window.open(
              "../../Reporte/LaTeX/Itinerario.php?v=" + JSON.stringify(vector),
              "_blank"
            );
          },
        },
      ],
    },
    footerCallback: function (row, data, start, end, display) {
      var api = this.api();
      // Remove the formatting to get integer data for summation
      var intVal = function (i) {
        return parseFloat(i);
      };
      // Total over all pages
      allTotal = api
        .column(6)
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);
      // Total over this page
      pageTotal = api
        .column(6, { page: "current" })
        .data()
        .reduce(function (a, b) {
          return intVal(a) + intVal(b);
        }, 0);
      // Update footer
      $(api.column(6).footer()).html(
        "&Sigma;: " + pageTotal + " (" + allTotal + " en total)"
      );
    },
  });

  new $.fn.dataTable.Buttons(tabla, {
    buttons: [
      {
        extend: "pageLength",
        className: "btn btn-outline-info",
      },
      {
        extend: "colvis",
        className: "btn btn-outline-info",
        collectionLayout: "three-column",
        text: function () {
          return "Columnas";
        },
        prefixButtons: [
          {
            extend: "colvisGroup",
            text: "Todo",
            show: ":hidden",
          },
          {
            extend: "colvisRestore",
            text: "Restaurar",
          },
        ],
        //      }, {
        //        className: 'btn btn-outline-info',
        //        extend: 'collection',
        //        text: 'Exportar',
        //        buttons: [{
        //            text: 'Excel',
        //            extend: 'excelHtml5',
        //            footer: false,
        //            exportOptions: {
        //              columns: ':visible'
        //            }
        //          }, {
        //            text: 'CSV',
        //            extend: 'csvHtml5',
        //            fieldSeparator: ';',
        //            exportOptions: {
        //              columns: ':visible'
        //            }
        //          }, {
        //            text: 'PDF Portrait',
        //            extend: 'pdfHtml5',
        //            message: '',
        //            exportOptions: {
        //              columns: ':visible'
        //            }
        //          }, {
        //            text: 'PDF Landscape',
        //            extend: 'pdfHtml5',
        //            message: '',
        //            orientation: 'landscape',
        //            exportOptions: {
        //              columns: ':visible'
        //            }
        //          }]
      },
    ],
  });
  tabla.buttons(1, null).container().appendTo($("div.devlp"));
  //CUALQUIERA LOS BOTONES O del usuario en tabla
  tabla
    .on("select", function (e, dt, type, indexes) {
      tr();
    })
    .on("deselect", function (e, dt, type, indexes) {
      tr();
    });

  function tr() {
    var l = tabla.rows({ selected: true }).ids().toArray().length;
    if (l === 0) {
      $(".nada").hide();
      $(".todo").show();
    } else if (l > 0) {
      $(".nada").show();
      $(".todo").hide();
    }
  }

  $(".todo").click(function () {
    tabla.rows({ search: "applied" }).select();
  });
  $(".nada").click(function () {
    tabla.rows().deselect();
  });

  function numeral(c) {
    var u = "";
    if ($.isNumeric(c)) {
      //del cliente
      var su = parseInt(c) - 1000;
      u = su + "";
    } else {
      var su = parseInt(c.slice(1)) - 1000;
      u = c.charAt(0) + su + "";
    }
    return u;
  }
  function iterativo(dt, p) {
    var vector = [];
    $.each(dt.rows(".selected").data(), function () {
      vector.push(numeral(this[1])); //la columna donde esta
    });
    $.ajax({
      url: "cancelar.php",
      data: {
        v: vector,
        s: p,
      },
      type: "post",
      beforeSend: function () {},
      success: function (output) {
        if (output.charAt(0) == "X") {
          alert(output.slice(1));
        } else {
          alert(output);
          window.open("frm_listar_1_1.php", "_self");
        }
      },
    });
  }
  $(".fch1").change(function () {
    var x = this.value;
    if (x !== "") {
      var t = x.split("-"); //anio mes dia
      m = new Date(t[0], t[1] - 1, t[2]);
    } else {
      //causa que piense mucho?
      m = NaN;
    }
    tabla.draw();
  });
  $(".fch2").change(function () {
    var x = this.value;
    if (x !== "") {
      var t = x.split("-"); //anio mes dia
      n = new Date(t[0], t[1] - 1, t[2]);
    } else {
      //causa que piense mucho?
      n = NaN;
    }
    tabla.draw();
  });

  $("input[name=ljk]").change(function () {
    tabla.columns(tt).search("").draw();
    tt = parseInt($(this).val());
    tabla.draw();
  });

  $(".bter,.ml").on("keyup", function (e) {
    var m = parseInt($("input").index($(e.currentTarget))) + 1;
    tabla.columns(m).search(this.value).draw();
  });

  $(".lep").change(function (e) {
    var m = parseInt($("select").index($(e.currentTarget))) + 8;
    tabla.columns(m).search(this.value).draw();
  });

  $(".bter").addClear({
    top: 42,
    right: 15,
    symbolClass: "fa fa-times-circle",
    onClear: function (e) {
      var t = parseInt($("input").index(e)) + 1;
      tabla.columns(t).search("").draw();
    },
  });

  $(".ml").addClear({
    top: 42,
    right: 45,
    symbolClass: "fa fa-times-circle",
    onClear: function (e) {
      var t = parseInt($("input").index(e)) + 1;
      tabla.columns(t).search("").draw();
    },
  });
});
