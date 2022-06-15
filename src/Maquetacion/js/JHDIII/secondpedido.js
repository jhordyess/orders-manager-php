function validateForm() {
  var t=true;
  var x = $('input[name="ftg"]:checked').val();
  var y = $('input[name="ali"]').val();
  if (x === "1"&&y!=="") {
    alert("No puede tener un pedido cancelado y con fecha entregada");
    t=false;
  }
  $('select').each(function() {
    if(this.value==='-1'){
      t=(t&&false);
      alert("Seleccione talla");
    }
  });
  if(!t){
    return false;
  }
}
var n2n = 1;
$(document).on('click', '#maspoleras', function () {
  n2n++;
  $.ajax({
    url: '../plantilla/nton.php',
    type: 'post',
    beforeSend: function () {
      $("#botob").remove();
    },
    success: function (output) {
      $("#incremental").append(output);
    }
  });
});
$(document).on('click', '#menpoleras', function (e) {
  n2n--;
  var z = $(e.currentTarget).parent().parent();
  //var rest=parseFloat(z.find('input.subi').val());
  var rest=parseInt(z.find('input.subi').val());
  var l = parseInt($('.row').index(z)) - 1;//por alguna razon el segundo es el 7...le siguen los demas sustantivamente.
  z.remove();
  var p = '';
  if (n2n === 1) {//alerta si hay modificacion se deben modificar todos
    p = "<div class='col col-sm-1' id='botob'>"
            + "<button type='button' class='btn btn-default btn-circle' style='margin-top: 35px' id='maspoleras'>"
            + "<i class='fas fa-plus'></i>"
            + "</button>"
            + "</div>";
  } else {
    p = "<div class='col col-sm-1' id='botob'>"
            + "<button type=button class='btn btn-default btn-circle' style='margin-top: 5px' id='maspoleras'>"
            + "<i class='fas fa-plus'></i>"
            + "</button>" + "<span style='margin-right:12px'></span>"
            + "<button type='button' class='btn btn-default btn-circle' style='margin-top: 5px' id='menpoleras'>"
            + "<i class='fas fa-minus'></i>"
            + "</button>"
            + "</div>";
  }
  $("#incremental").find($('.row').get(l)).append(p);
  
  if (!isNaN(rest)) {
//    var su=parseFloat($('#total').val())-rest;
    var su=parseInt($('#total').val())-rest;
    $('#total').val(su);
//    su = Math.round((su - parseFloat($('#cuenta').val())) * 100) / 100;
    su = su - parseInt($('#cuenta').val());
    $('#saldo').val(su);
  }
});
///--- para la suma---------///
//añadir al subtotal, total y saldo cuando se digita la cantidad
$(document).on('keyup', '.cali', function (e) {
  var u = $(e.currentTarget).parent().parent();
  var y = e.currentTarget.value;
  var x = u.find('.preci').val();
//  var z = Math.round(x * y * 100) / 100;
  var z = x * y;
  var o = u.find('.subi');
  var m = o.val();
  o.val(z);
  //var t = Math.round((parseFloat($('#total').val()) + z - m) * 100) / 100;
  var t = parseInt($('#total').val()) + z - m;
  $('#total').val(t);
  //x = Math.round((parseFloat($('#cuenta').val())) * 100) / 100;
  x = parseInt($('#cuenta').val());
  if (!isNaN(x)) {
//    var z = Math.round((t - x) * 100) / 100;
    var z = t - x;
    $('#saldo').val(z);
  }
});
//añadir al subtotal, total y saldo cuando se digita un precio
$(document).on('keyup', '.preci', function (e) {
  var u = $(e.currentTarget).parent().parent();
  var x = u.find('.cali').val();
  var y = e.currentTarget.value;
//var z = Math.round(x * y * 100) / 100;
  var z = x * y;
  var o = u.find('.subi');//subtotal
  var m = o.val();
  o.val(z);
//var t = Math.round((parseFloat($('#total').val()) + z - m) * 100) / 100;
  var t = parseInt($('#total').val()) + z - m;
  $('#total').val(t);
//x = Math.round((parseFloat($('#cuenta').val())) * 100) / 100;
  x = parseInt($('#cuenta').val());
  if (!isNaN(x)) {
    //    var z = Math.round((t - x) * 100) / 100;
    var z = t - x;
    $('#saldo').val(z);
  }
});
///------------///
$(document).ready(function () {
  //para tratar de validar
  var t=$('input[type="radio"]').length-1;
  $($('input[type="radio"]')[0]).prop('required',true);
  $($('input[type="radio"]')[t]).prop('required',true);
  //para actualizar n
  n2n=$('.row').length-12;//necesario...
  //añadir al saldo cuando la a cuenta
  $('#cuenta').keyup(function (e) {
//    var x = parseFloat($('#total').val());
//    var y = parseFloat(e.currentTarget.value);
//    var z = Math.round((x - y) * 100) / 100;
    var x = parseInt($('#total').val());
    var y = parseInt(e.currentTarget.value);
    var z = x - y;
    $('#saldo').val(z);
  });
  ///
  var sPageURL = window.location.search.substring(1);
  var sURLVariables = sPageURL.split('&');
  var sParameterName = sURLVariables[0].split('=');
  if (sParameterName[1] === '') {
    var d = new Date().getDate();
    var m = new Date().getMonth() + 1;
    var y = new Date().getFullYear();
    if (d < 10) {
      d = '0' + d;
    }
    if (m < 10) {
      m = '0' + m;
    }
    $("#fecha").prop('value', y + "-" + m + "-" + d);
    $("#entrega").prop('min', y + "-" + m + "-" + d);
  }

$("input[list='evets']").focusout(function () {//para llenar sw de evento
    var cli = this.value;
    if (cli !== '') {
      $.ajax({
        url: '../plantilla/ajax.php',
        data: {
          "a": "2",
          "id": cli
        },
        type: 'post',
        success: function (output) {
            if(output==1){
            $('#ch2').prop('checked', true);
          }else{
            $('#ch2').prop('checked', false);
          }
        }
      });
    } else {
      $('#ch2').prop('checked', false);
    }
  });


  $("input[list='clos']").focusout(function () {//para llenar cliente
    var cli = this.value;
    if (cli !== '') {
      $.ajax({
        url: '../plantilla/ajax.php',
        data: {
          "a": "1",
          "id": cli
        },
        type: 'post',
        success: function (output) {
          var res = output.split(",");
          $("#y").val(res[0]);
          $("#z").val(res[1]);
          if(res[2]==1){
            $('#ch1').prop('checked', true);
          }else{
            $('#ch1').prop('checked', false);
          }
        }
      });
    } else {
      $("#y").val("");
      $("#z").val("");
      $('#ch1').prop('checked', false);
    }
  });
  $("input[list='dis']").focusout(function () {//para llenar sw de destino
    var cli = this.value;
    if (cli !== '') {
      $.ajax({
        url: '../plantilla/ajax.php',
        data: {
          "a": "3",
          "id": cli
        },
        type: 'post',
        success: function (output) {
            if(output==1){
            $('#ch4').prop('checked', true);
          }else{
            $('#ch4').prop('checked', false);
          }
        }
      });
    } else {
      $('#ch4').prop('checked', false);
    }
  });
  
  $("input[list='evets'],input[list='dis'],input[list='clos']").addClear({
    top: 42,
    right: 50,
    symbolClass: "fa fa-times-circle"
  });
});